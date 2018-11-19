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
use UthandoBlog\Form\CategoryForm;
use UthandoBlog\Hydrator\CategoryHydrator;
use UthandoBlog\InputFilter\CategoryInputFilter;
use UthandoBlog\Mapper\CategoryMapper;
use UthandoBlog\Model\CategoryModel;
use UthandoCommon\Mapper\AbstractNestedSet;
use UthandoCommon\Model\ModelInterface;
use UthandoCommon\Service\AbstractMapperService;
use Zend\Form\Form;

/**
 * Class Category
 * @package UthandoBlog\Service
 */
class CategoryService extends AbstractMapperService
{
    protected $form         = CategoryForm::class;
    protected $hydrator     = CategoryHydrator::class;
    protected $inputFilter  = CategoryInputFilter::class;
    protected $mapper       = CategoryMapper::class;
    protected $model        = CategoryModel::class;

    protected $tags = [
        'blog-category', 'blog-post',
    ];

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

        $form = $this->prepareForm($model, $post, true, true);

        /* @var CategoryInputFilter $inputFilter */
        $inputFilter = $form->getInputFilter();
        $inputFilter->addSeoNoRecordExists($model->getSeo());

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

    public function getCategoryBySeo($seo)
    {
        return $this->getMapper()->getCategoryBySeo($seo);
    }
}