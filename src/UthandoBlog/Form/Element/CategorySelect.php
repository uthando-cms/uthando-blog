<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 26/08/17 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoBlog\Form\Element;

use UthandoBlog\Service\CategoryService;
use UthandoCommon\Service\ServiceManager;
use Zend\Form\Element\Select;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class CategorySelect
 * @package UthandoBlog\Form\Element
 * @method AbstractPluginManager getServiceLocator()
 */
class CategorySelect extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    protected $emptyOption = '---Select a category---';

    protected $addTop = false;

    public function setOptions($options)
    {
        parent::setOptions($options);

        if (isset($options['add_top'])) {
            $this->addTop = $options['add_top'];
        }

        if (array_key_exists('empty_option', $options)) {
            $this->setEmptyOption($options['empty_option']);
        }
    }

    public function getValueOptions(): array
    {
        $options = $this->valueOptions ?: $this->getOptionList();
        return $options;
    }

    public function getOptionList(): array
    {
        /* @var $categoryService \UthandoBlog\Service\CategoryService */
        $categoryService = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class)
            ->get(CategoryService::class);

        $categoryService->getMapper();
        $categories = $categoryService->fetchAll();

        $categoryOptions = [];

        if ($this->isAddTop()) {
            $categoryOptions[0] = 'Top';
        }

        /* @var $category \UthandoBlog\Model\CategoryModel */
        foreach($categories as $category) {
            $ident = ($category->getDepth() > 0) ? str_repeat('&nbsp;&nbsp;',($category->getDepth())) . '&bull;&nbsp;' : '';
            $categoryOptions[] = [
                'label'	                => $ident . $category->getName(),
                'value'	                => $category->getCategoryId(),
                'disable_html_escape'   => true,
            ];
        }

        return $categoryOptions;
    }

    /**
     * @return boolean
     */
    public function isAddTop(): bool
    {
        return $this->addTop;
    }

    /**
     * @param boolean $addTopOption
     * @return $this
     */
    public function setAddTop(bool $addTopOption): CategorySelect
    {
        $this->addTop = $addTopOption;
        return $this;
    }
}
