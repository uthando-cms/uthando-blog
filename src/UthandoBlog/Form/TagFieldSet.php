<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 22/08/17 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoBlog\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use UthandoBlog\Hydrator\Tag as TagHydrator;
use UthandoBlog\Model\Tag as TagModel;
use Zend\Filter\Digits;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\StringLength;

/**
 * Class CategoryFieldSet
 * @package UthandoBlog\Form
 */
class TagFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->setHydrator(new TagHydrator())
            ->setObject(new TagModel());
    }

    public function init()
    {
        $this->add([
            'name' => 'name',
            'type' => Text::class,
            'options' => [
                'label'     => 'Name',
                'required'  => true,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'Tag Name',
            ],
        ]);

        $this->add([
            'name' => 'categoryId',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name' => 'security',
            'type' => Csrf::class,
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'categoryId' => [
                'required' => false,
                'filters' => [
                    ['name' => StringTrim::class],
                    ['name' => StripTags::class],
                    ['name' => Digits::class]
                ],
            ],
            'name' => [
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
            ],
        ];
    }
}
