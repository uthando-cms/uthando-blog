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

use UthandoBlog\Model\Tag as TagModel;
use UthandoCommon\Service\AbstractRelationalMapperService;
use UthandoBlog\Mapper\Post as PostMapper;
use UthandoBlog\Model\Post as PostModel;
use Zend\Db\Sql\Where;
use Zend\EventManager\Event;

/**
 * Class Post
 *
 * @package UthandoBlog\Service
 * @method PostMapper getMapper($mapperClass = null, array $options = [])
 */
class Post extends AbstractRelationalMapperService
{
    protected $serviceAlias = 'UthandoBlogPost';

    /**
     * @var array
     */
    protected $referenceMap = [
        'category' => [
            'refCol' => 'categoryId',
            'service' => 'UthandoBlogCategory',
        ],
        'tags' => [
            'refCol' => 'postId',
            'service' => 'UthandoBlogTag',
            'getMethod' => 'getTagsByPostId'
        ],
        'user' => [
            'refCol' => 'userId',
            'service' => 'UthandoUser',
        ],
    ];

    /**
     * Attach events
     */
    public function attachEvents()
    {
        $this->getEventManager()->attach([
            'pre.form'
        ], [$this, 'setSlug']);

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
            'post.delete'
        ], [$this, 'removePostTag']);
    }

    public function removePostTag(Event $e)
    {
        $id = $e->getParam('id');

        $where = new Where();
        $where->equalTo('postId', $id);
        $this->getMapper()->delete($where, 'blogPostTag');
    }

    public function setTagsArray(Event $e)
    {
        $model = $e->getParam('model');
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
    public function setSlug(Event $e)
    {
        $data = $e->getParam('data');

        if (null === $data) {
            return;
        }

        if ($data instanceof PostModel) {
            $data->setSlug($data->getTitle());
        } elseif (is_array($data)) {
            $data['slug'] = $data['title'];
        }

        $e->setParam('data', $data);
    }

    /**
     * @param Event $e
     */
    public function setValidation(Event $e)
    {
        $form = $e->getParam('form');
        $model = $e->getParam('model');
        $post = $e->getParam('post');

        if ($model instanceof PostModel) {
            $model->setDateModified();
        }

        $form->setValidationGroup([
            'postId', 'userId', 'title', 'slug',
            'content', 'description', 'categoryId',
            'tags', 'image', 'lead', 'layout',
        ]);
    }

    /**
     * @param Event $e
     */
    public function saveTags(Event $e)
    {
        $model      = $e->getParam('model');
        $post       = $e->getParam('post');
        $saved      = $e->getParam('saved');
        $tags       = $model->getTags();

        /* @var Tag $tagService */
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
} 