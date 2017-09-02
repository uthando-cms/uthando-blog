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

use UthandoBlog\Mapper\Tag as TagMapper;
use UthandoBlog\Model\Tag as TagModel;
use UthandoCommon\Service\AbstractMapperService;
use Zend\Db\Sql\Where;
use Zend\EventManager\Event;

/**
 * Class Tag
 * @package UthandoBlog\Service
 * @method TagMapper getMapper($mapperClass = null, array $options = [])
 */
class Tag extends AbstractMapperService
{
    protected $serviceAlias = 'UthandoBlogTag';

    /**
     * Attach events
     */
    public function attachEvents()
    {
        $this->getEventManager()->attach([
            'pre.add', 'pre.edit'
        ], [$this, 'checkSeo']);

        $this->getEventManager()->attach([
            'post.delete'
        ], [$this, 'removePostTag']);
    }

    public function removePostTag(Event $e)
    {
        $id = $e->getParam('id');

        $where = new Where();
        $where->equalTo('tagId', $id);
        $this->getMapper()->delete($where, 'blogPostTag');
    }

    public function checkSeo(Event $e)
    {
        $data = $e->getParam('post');
        $form = $e->getParam('form');
        $model = $e->getParam('model', new TagModel());

        if (null === $data) {
            return;
        }

        if ($data instanceof TagModel) {
            $data->setSeo($data->getName());
        } elseif (is_array($data)) {
            $data['seo'] = $data['name'];
        }

        $seo = ($model->getSeo() === $data['seo']) ? $model->getSeo() : null;

        /* @var \UthandoBlog\InputFilter\Tag $inputFilter */
        $inputFilter = $form->getInputFilter();
        $inputFilter->addSeoNoRecordExists($seo);

        $form->setData($data);

        $e->setParam('post', $data);
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
}