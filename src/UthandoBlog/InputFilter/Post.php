<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 * 
 * @package   UthandoNews\InputFilter
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoBlog\InputFilter;

use Zend\InputFilter\InputFilter;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class Blog
 *
 * @package UthandoBlog\InputFilter
 */
class Post extends InputFilter implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function init()
    {
        $this->add([
            'name' => 'postId',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'Digits'],
            ],
        ]);

        $this->add([
            'name' => 'userId',
            'required'      => true,
            'filters'       => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
                ['name' => 'Digits'],
            ],
            'validators'    => [

            ],
        ]);

        $this->add([
            'name' => 'categoryId',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'Digits'],
            ],
        ]);

        $this->add([
            'name' => 'tags',
            'required'      => false,
            'filters'       => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
        ]);

        $this->add([
            'name' => 'title',
            'required'      => true,
            'filters'       => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators'    => [
                ['name' => 'StringLength', 'options' => [
                    'encoding' => 'UTF-8',
                    'min' => 2,
                    'max' => 255
                ]],
            ],
        ]);

        $this->add([
            'name' => 'slug',
            'required'      => true,
            'filters'       => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
                ['name' => 'UthandoCommon\Filter\Slug'],
            ],
            'validators'    => [
                ['name' => 'StringLength', 'options' => [
                    'encoding' => 'UTF-8',
                    'min' => 2,
                    'max' => 255
                ]],
            ],
        ]);

        $this->add([
            'name' => 'image',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
            ],
            'validators' => [
                ['name'    => 'StringLength','options' => [
                    'encoding' => 'UTF-8',
                    'max'      => 255,
                ]],
            ],
        ]);

        $this->add([
            'name' => 'layout',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
            ],
            'validators' => [
                ['name'    => 'StringLength','options' => [
                    'encoding' => 'UTF-8',
                    'max'      => 255,
                ]],
            ],
        ]);

        $this->add([
            'name' => 'lead',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
            ],
            'validators' => [
                ['name'    => 'StringLength','options' => [
                    'encoding' => 'UTF-8',
                ]],
            ],
        ]);

        $this->add([
            'name' => 'description',
            'required'      => true,
            'filters'       => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators'    => [
                ['name' => 'StringLength', 'options' => [
                    'encoding' => 'UTF-8',
                    'min' => 30,
                    'max' => 255
                ]],
            ],
        ]);
    }

    public function addSlugNoRecordExists($exclude = null)
    {
        $exclude = (!$exclude) ?: [
            'field' => 'slug',
            'value' => $exclude,
        ];

        $this->get('slug')
            ->getValidatorChain()
            ->attachByName('Zend\Validator\Db\NoRecordExists', [
                'table' => 'blogPost',
                'field' => 'slug',
                'adapter' => $this->getServiceLocator()->getServiceLocator()->get('Zend\Db\Adapter\Adapter'),
                'exclude' => $exclude,
            ]);

        return $this;
    }
} 