<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoBlog\View\Helper;

use UthandoBlog\Model\Category as CategoryModel;
use UthandoBlog\Service\Category as CategoryService;
use UthandoCommon\View\AbstractViewHelper;

/**
 * Class Categories
 *
 * @package UthandoBlog\View\Helper
 */
class Categories extends AbstractViewHelper
{
    protected $service;

    public function categoryLink(CategoryModel $cat)
    {
        $html = '';

        $html .= '<a href="' . $this->getView()->url('post-list/category', [
                'category' => $cat->getSeo(),
            ]) . '">' . $cat->getName() . '</a>';

        return $html;
    }

    public function categoryMenu()
    {
        $categories = $this->getService()->fetchAll('lft');
        $categories->getHydrator()->addDepth(true);

        return $this->getView()->partial('uthando-blog/partial/category-menu', [
            'categories' => $categories,
        ]);
    }

    /**
     * @return CategoryService
     */
    public function getService()
    {
        if (!$this->service instanceof CategoryService) {

            $service = $this->getServiceLocator()
                ->getServiceLocator()
                ->get('UthandoServiceManager')
                ->get('UthandoBlogCategory');
            $this->setService($service);
        }

        return $this->service;
    }

    /**
     * @param CategoryService $service
     * @return $this
     */
    public function setService(CategoryService $service)
    {
        $this->service = $service;
        return $this;
    }
}