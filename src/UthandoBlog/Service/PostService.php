<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 * 
 * @package   UthandoNews\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoBlog\Service;

use UthandoBlog\Form\PostForm;
use UthandoBlog\Hydrator\PostHydrator;
use UthandoBlog\InputFilter\PostInputFilter;
use UthandoBlog\Model\TagModel;
use UthandoBlog\Options\BlogOptions;
use UthandoCommon\Service\AbstractRelationalMapperService;
use UthandoBlog\Mapper\PostMapper;
use UthandoBlog\Model\PostModel;
use UthandoUser\Service\UserService;
use Zend\Db\Sql\Where;
use Zend\EventManager\Event;

/**
 * Class Post
 *
 * @package UthandoBlog\Service
 * @method PostMapper getMapper($mapperClass = null, array $options = [])
 */
class PostService extends AbstractRelationalMapperService
{
    protected $form         = PostForm::class;
    protected $hydrator     = PostHydrator::class;
    protected $inputFilter  = PostInputFilter::class;
    protected $mapper       = PostMapper::class;
    protected $model        = PostModel::class;

    protected $autoPost = false;

    /**
     * @var array
     */
    protected $referenceMap = [
        'category' => [
            'refCol' => 'categoryId',
            'service' => CategoryService::class,
        ],
        'tags' => [
            'refCol' => 'postId',
            'service' => TagService::class,
            'getMethod' => 'getTagsByPostId'
        ],
        'user' => [
            'refCol' => 'userId',
            'service' => UserService::class,
        ],
    ];

    protected $tags = [
        'blog-post',
    ];

    /**
     * Attach events
     */
    public function attachEvents()
    {
        $this->getEventManager()->attach([
            'pre.form'
        ], [$this, 'setTagsArray']);

        $this->getEventManager()->attach([
            'pre.add', 'pre.edit'
        ], [$this, 'setValidation']);

        $this->getEventManager()->attach([
            'post.add', 'post.edit'
        ], [$this, 'saveTags']);

        $this->getEventManager()->attach([
            'post.edit'
        ], [$this, 'autoPostEdit']);

        $this->getEventManager()->attach([
            'post.add',
        ], [$this, 'autoPostAdd']);
    }

    public function setTagsArray(Event $e)
    {
        $model = $e->getParam('model');

        if (!$model instanceof PostModel) {
            return;
        }

        $tags = $model->getTags();

        $tagsArray = [];

        foreach ($tags as $tag) {
            if ($tag instanceof TagModel) {
                $tagsArray[] = $tag->getTagId();
            } else {
                $tagsArray[] = $tag;
            }
        }

        $model->setTags($tagsArray);
    }

    /**
     * @param Event $e
     */
    public function setValidation(Event $e)
    {
        $form = $e->getParam('form');
        $model = $e->getParam('model', new PostModel());
        $post = $e->getParam('post');

        if ($model instanceof PostModel) {
            $model->setDateModified();
        }

        if (!$post['slug']) {
            $post['slug'] = $post['title'];
        }

        if (PostModel::STATUS_PUBLISHED == $post['status'] && PostModel::STATUS_DRAFT == $model->getStatus()) {
            $post['dateCreated'] = '';
            $this->autoPost = true;
            $model->setDateCreated();
        }

        /* @var \UthandoBlog\InputFilter\PostInputFilter $inputFilter */
        $inputFilter = $form->getInputFilter();
        $inputFilter->addSlugNoRecordExists($model->getSlug());

        /* @var \UthandoBlog\Options\BlogOptions $options */
        $options = $this->getServiceLocator()
            ->getServiceLocator()->get(BlogOptions::class);

        $hydrator = $form->getHydrator();
        /* @var DateTime $dateTimeStrategy */
        $dateTimeStrategy = $hydrator->getStrategy('dateCreated');
        $dateTimeStrategy->setHydrateFormat($options->getDateFormat());
        $dateTimeStrategy = $hydrator->getStrategy('dateModified');
        $dateTimeStrategy->setHydrateFormat($options->getDateFormat());

        $form->setValidationGroup([
            'postId', 'userId', 'title', 'slug',
            'content', 'description', 'categoryId',
            'tags', 'image', 'lead', 'layout', 'status',
            'dateCreated', 'enableComments',
        ]);

        $form->setData($post);

        $e->setParam('post', $post);
    }

    public function autoPostAdd(Event $e)
    {
        $id         = $e->getParam('saved');
        $model      = $this->getById($id);

        $this->autoPost($model);
    }

    public function autoPostEdit(Event $e)
    {
        $model      = $e->getParam('model');

        $this->autoPost($model);
    }

    public function autoPost(PostModel $model)
    {
        if (PostModel::STATUS_PUBLISHED === $model->getStatus() && true === $this->autoPost) {

            /* @var $options BlogOptions */
            $options = $this->getService(BlogOptions::class);

            $viewManager = $this->getServiceLocator()
                ->get('ViewHelperManager');

            $url = $viewManager->get('Url');
            $scheme = $viewManager->get('ServerUrl');

            $url = $url('blog', [
                'post-item'    => $model->getSlug(),
            ]);

            $string = sprintf('%s %s', $model->getTitle(), $scheme($url));

            $argv   = compact('string');
            $argv   = $this->prepareEventArguments($argv);

            foreach ($options->getAutoPost() as $event) {
                $this->getEventManager()->trigger($event, $this, $argv);
            }
        }
    }

    public function saveTags(Event $e)
    {
        $model      = $e->getParam('model', new PostModel());
        $post       = $e->getParam('post');
        $saved      = $e->getParam('saved');
        $tags       = $post['tags'];

        /* @var TagService $tagService */
        $tagService = $this->getRelatedService('tags');
        $mapper     = $tagService->getMapper();
        $id         = $model->getPostId() ?? $saved;

        $currentTags = $tagService->getTagsByPostId($id);
        $keptTags = [];

        /* @var TagModel $tag */
        foreach ($currentTags as $tag) {
            if (!in_array($tag->getTagId(), $tags)) {
                $where = new Where();
                $where->equalTo('tagId', $tag->getTagId())
                    ->and->equalTo('postId', $id);
                $mapper->delete($where, 'blogPostTag');
            } else {
                $keptTags[] = $tag->getTagId();
            }
        }

        $tags = array_diff($tags, $keptTags);

        foreach ($tags as $tag) {
            $mapper->insert([
                'tagId' => $tag,
                'postId' => $id
            ], 'blogPostTag');
        }
    }

    /**
     * @param int $id
     * @param null $col
     * @return array|mixed|\UthandoCommon\Model\ModelInterface
     */
    public function getById($id, $col = null)
    {
        $model = parent::getById($id, $col);
        $this->populate($model, true);

        return $model;
    }

    public function searchPosts($post, $sort)
    {
        $searches = [];
        $type = [];

        foreach ($post as $key => $value) {
            switch ($key) {
                case 'tag':
                case 'category':
                case 'archive':
                    if (!$value || (is_array($value) && !array_filter($value))) continue;
                    $type = [$key, $value];
                    break;
                default:
                    $searches[] = [
                        'searchString' => $value,
                        'columns' => explode('-', $key),
                    ];
                    break;
            }
        }

        $models = $this->getMapper()->searchPosts($searches, $sort, $type);

        foreach ($models as $model) {
            $this->populate($model, true);
        }

        return $models;
    }

    /**
     * @param $slug
     * @return PostModel|null
     */
    public function getBySlug($slug)
    {
        $slug = (string) $slug;
        $mapper = $this->getMapper();
        $model = $mapper->getBySlug($slug);

        if ($model) {
            $this->populate($model, true);
        }

        return $model;
    }

    /**
     * @param PostModel $postModel
     */
    public function addPageHit(PostModel $postModel)
    {
        $pageHits = $postModel->getHits();
        $pageHits++;
        $postModel->setHits($pageHits);
        $this->save($postModel);
    }

    /**
     * @param int $limit
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getPopularPosts(int $limit)
    {
        $mapper = $this->getMapper();
        $models = $mapper->getPostsByHits($limit);

        return $models;
    }

    /**
     * @param int $limit
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getRecentPosts(int $limit)
    {
        $mapper = $this->getMapper();
        $models = $mapper->getPostsByDate($limit);

        return $models;

    }

    public function getArchiveList()
    {
        $mapper = $this->getMapper();
        $archiveList = $mapper->getArchiveList();

        return $archiveList;
    }
} 