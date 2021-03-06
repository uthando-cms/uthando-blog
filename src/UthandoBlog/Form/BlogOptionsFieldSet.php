<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNews\Form
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2015 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoBlog\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use UthandoBlog\Options\BlogOptions;
use UthandoTwitter\Form\SocialMediaFieldSet;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\Form\Element\Number;
use Zend\Form\Element\Text;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\Digits;
use Zend\Validator\StringLength;

class BlogOptionsFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->setHydrator(new ClassMethods())
            ->setObject(new BlogOptions());
    }

    public function init()
    {
        $this->add([
            'name' => 'sort_order',
            'type' => Text::class,
            'options' => [
                'label' => 'Sort Order',
                'column-size' => 'md-8',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name' => 'items_per_page',
            'type' => Number::class,
            'options' => [
                'label' => 'Posts Per Page',
                'column-size' => 'md-8',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
           'name' => 'date_format',
           'type' => Text::class,
           'options' => [
               'label' => 'Date Format',
               'column-size' => 'md-8',
               'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
               'label_attributes' => [
                   'class' => 'col-md-4',
               ],
           ],
        ]);

        $this->add([
            'type' => SocialMediaFieldSet::class,
            'name' => 'auto_post',
            'options' => [
                'label' => 'Auto Post To:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
            ],
            'attributes' => [
                'class' => 'col-md-12',
            ],
        ]);
    }

    public function getInputFilterSpecification(): array
    {
        return [
            'sort_order' => [
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
            'items_per_page' => [
                'required'      => true,
                'filters'       => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => ToInt::class],
                ],
                'validators'    => [
                    ['name' => Digits::class],
                ],
            ],
            'date_format' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    ['name' => StringLength::class, 'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 255,
                    ]],
                ],
            ],
        ];
    }
}
