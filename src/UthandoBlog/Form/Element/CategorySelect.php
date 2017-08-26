<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 26/08/17 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoBlog\Form\Element;


use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class CategorySelect
 * @package UthandoBlog\Form\Element
 */
class CategorySelect extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    protected $emptyOption = '---Please select a category---';

    public function getValueOptions()
    {
        return ($this->valueOptions) ?: $this->getUsers();
    }

    public function getUsers()
    {
        $categories = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('UthandoServiceManager')
            ->get('UthandoBlogCategory')
            ->fetchAll();

        $categoryOptions = [];

        /* @var $category \UthandoBlog\Model\Category */
        foreach ($categories as $category) {
            $categoryOptions[] = [
                'label' => $category->getName(),
                'value' => $category->getCategoryId(),
            ];
        }

        return $categoryOptions;
    }
}
