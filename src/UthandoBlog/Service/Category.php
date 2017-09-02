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

use Exception;
use UthandoBlog\InputFilter\Category as CategoryInputFilter;
use UthandoBlog\Mapper\Category as CategoryMapper;
use UthandoBlog\Model\Category as CategoryModel;
use UthandoCommon\Mapper\AbstractNestedSet;
use UthandoCommon\Model\ModelInterface;
use UthandoCommon\Service\AbstractMapperService;
use Zend\Form\Form;

/**
 * Class Category
 * @package UthandoBlog\Service
 */
class Category extends AbstractMapperService
{
    protected $serviceAlias = 'UthandoBlogCategory';

    /**
     * @param array $post
     * @param Form $form
     * @return int|Form
     */
    public function add(array $post, Form $form = null)
    {
        if (!$post['seo']) {
            $post['seo'] = $post['name'];
        }

        /* @var $mapper CategoryMapper */
        $mapper = $this->getMapper();

        /* @var $model CategoryModel */
        $model = $mapper->getModel();

        $form = $this->prepareForm($model, $post, true, true);

        /* @var CategoryInputFilter $inputFilter */
        $inputFilter = $form->getInputFilter();
        $inputFilter->addSeoNoRecordExists();

        if (!$form->isValid()) {
            return $form;
        }

        $data = $mapper->extract($form->getData());

        $pk = $this->getMapper()->getPrimaryKey();
        unset($data[$pk]);

        $position = (int)$post['parent'];
        $insertType = (string)$post['insertType'];

        $result = $mapper->insertRow($data, $position, $insertType);

        return $result;
    }

    /**
     * @param ModelInterface $model
     * @param array $post
     * @param Form|null $form
     * @return int|Form
     * @throws Exception
     */
    public function edit(ModelInterface $model, array $post, Form $form = null)
    {
        if (!$model instanceof CategoryModel) {
            throw new Exception('$model must be an instance of UthandoBlog\Model\Category, ' . get_class($model) . ' given.');
        }

        if (!$post['seo']) {
            $post['seo'] = $post['name'];
        }

        $seo = ($model->getSeo() === $post['seo']) ? $model->getSeo() : null;

        /* @var CategoryInputFilter $inputFilter */
        $inputFilter = $form->getInputFilter();
        $inputFilter->addSeoNoRecordExists($seo);

        $form = $this->prepareForm($model, $post, true, true);

        if (!$form->isValid()) {
            return $form;
        }

        $category = $this->getById($model->getCategoryId());

        $data = $this->getMapper()
            ->extract($form->getData());

        if ($category) {
            if (AbstractNestedSet::INSERT_NO !== $post['insertType']) {

                $position = (int)$post['parent'];
                $insertType = (string)$post['insertType'];
                $result = $this->getMapper()->move($data, $position, $insertType);
            } else {
                $result = $this->save($model);
            }
            $this->removeCacheItem($model->getCategoryId());
        } else {
            throw new ShopException('Blog Category id does not exist');
        }

        return $result;
    }
}