<?php
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
use UthandoNews\Options\FeedOptions;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\StringLength;

class BlogFeedFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->setHydrator(new ClassMethods())
            ->setObject(new FeedOptions());
    }

    public function init()
    {
        $this->add([
            'name' => 'title',
            'type' => 'text',
            'options' => [
                'label' => 'Title',
                'column-size' => 'md-8',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name' => 'description',
            'type' => 'text',
            'options' => [
                'label' => 'Description',
                'column-size' => 'md-8',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'title' => [
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
            'description' => [
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
