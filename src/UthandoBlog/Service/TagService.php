<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 20/08/17 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoBlog\Service;

use UthandoBlog\Form\TagForm;
use UthandoBlog\Hydrator\TagHydrator;
use UthandoBlog\InputFilter\TagInputFilter;
use UthandoBlog\Mapper\TagMapper;
use UthandoBlog\Model\TagModel;
use UthandoCommon\Service\AbstractMapperService;
use Zend\EventManager\Event;

/**
 * Class Tag
 * @package UthandoBlog\Service
 * @method TagMapper getMapper($mapperClass = null, array $options = [])
 */
class TagService extends AbstractMapperService
{
    protected $form         = TagForm::class;
    protected $hydrator     = TagHydrator::class;
    protected $inputFilter  = TagInputFilter::class;
    protected $mapper       = TagMapper::class;
    protected $model        = TagModel::class;

    protected $tags = [
        'blog-tags', 'blog-post'
    ];

    /**
     * Attach events
     */
    public function attachEvents()
    {
        $this->getEventManager()->attach([
            'pre.add', 'pre.edit'
        ], [$this, 'checkSeo']);
    }

    public function checkSeo(Event $e)
    {
        $post = $e->getParam('post');
        $form = $e->getParam('form');
        $model = $e->getParam('model', new TagModel());

        if (null === $post) {
            return;
        }

        if (!$post['seo']) {
            $post['seo'] = $post['name'];
        }

        /* @var TagInputFilter $inputFilter */
        $inputFilter = $form->getInputFilter();
        $inputFilter->addSeoNoRecordExists($model->getSeo());

        $form->setData($post);

        $e->setParam('post', $post);
    }

    public function getTagsByPostId($id)
    {
        $mapper = $this->getMapper();
        $result = $mapper->getTagsByPostId($id);
        $tags = [];

        foreach ($result as $tag) {
            $tags[] = $tag;
        }

        return $tags;
    }

    public function getTagBySeo($seo)
    {
        return $this->getMapper()->getTagBySeo($seo);
    }

    public function getTagCloud()
    {
        return $this->getMapper()->getTagCloud();
    }
}