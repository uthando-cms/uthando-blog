<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 26/08/17 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoBlog\InputFilter;

use UthandoCommon\Filter\Slug;
use Zend\Filter\Digits;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\I18n\Validator\IsInt;
use Zend\InputFilter\InputFilter;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Validator\Db\NoRecordExists;
use Zend\Validator\GreaterThan;
use Zend\Validator\StringLength;

/**
 * Class Category
 * @package UthandoBlog\InputFilter
 */
class CategoryInputFilter extends InputFilter implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function init()
    {
        $this->add([
            'name' => 'categoryId',
            'required' => false,
            'filters' => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class],
                ['name' => Digits::class]
            ],
        ]);

        $this->add([
            'name' => 'name',
            'required'      => true,
            'filters'       => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators'    => [
                ['name' => StringLength::class, 'options' => [
                    'encoding' => 'UTF-8',
                    'min' => 2,
                    'max' => 255
                ]],
            ],
        ]);

        $this->add([
            'name'       => 'seo',
            'required'   => true,
            'filters'    => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class],
                ['name' => Slug::class]
            ],
            'validators' => [
                ['name' => StringLength::class, 'options' => [
                    'encoding' => 'UTF-8',
                    'min'      => 2,
                    'max'      => 255,
                ]],
            ],
        ]);

        $this->add([
            'name'			=> 'parent',
            'required'		=> false,
            'filters'		=> [
                ['name' => StringTrim::class],
                ['name' => StripTags::class],
            ],
            'validators'	=> [
                ['name' => IsInt::class],
                ['name' => GreaterThan::class, 'options' => [
                    'min' 		=> 0,
                    'inclusive'	=> true,
                ]],
            ],
        ]);
    }

    public function addSeoNoRecordExists($exclude = null)
    {
        $exclude = (!$exclude) ?: [
            'field' => 'seo',
            'value' => $exclude,
        ];

        $this->get('seo')
            ->getValidatorChain()
            ->attachByName(NoRecordExists::class, [
                'table' => 'blogCategory',
                'field' => 'seo',
                'adapter' => $this->getServiceLocator()->getServiceLocator()->get('Zend\Db\Adapter\Adapter'),
                'exclude' => $exclude,
            ]);

        return $this;
    }
}
