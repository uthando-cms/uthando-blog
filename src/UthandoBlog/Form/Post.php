<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 * 
 * @package   UthandoNews\Form
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoBlog\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use UthandoBlog\Form\Element\CategorySelect;
use UthandoBlog\Form\Element\TagSelect;
use UthandoBlog\Model\Post as PostModel;
use Zend\Form\Element\Button;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\DateTime;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;

/**
 * Class Post
 *
 * @package UthandoBlog\Form
 */
class Post extends Form
{
    public function init()
    {
        $this->add([
            'type'  => Select::class,
            'name' => 'status',
            'options' => [
                'label' => 'Status',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'value_options' => [
                    PostModel::STATUS_DRAFT => 'Draft',
                    PostModel::STATUS_PUBLISHED => 'Published',
                ]
            ],
        ]);

        $this->add([
            'name' => 'title',
            'type' => Text::class,
            'options' => [
                'label'     => 'Title',
                'required'  => true,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'Post Title',
            ],
        ]);

        $this->add([
            'name' => 'slug',
            'type' => Text::class,
            'options' => [
                'label'       => 'Slug',
                'required'    => false,
                'help-block' => 'If you leave this blank the the title will be used for the slug.',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'Slug',
            ],
        ]);

        $this->add([
            'name' => 'description',
            'type' => Text::class,
            'options' => [
                'label' => 'Description',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'Description',
            ],
        ]);

        $this->add([
            'name' => 'categoryId',
            'type' => CategorySelect::class,
            'options' => [
                'label' => 'Category',
                'empty_option' => 'No category',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'tags',
            'type' => TagSelect::class,
            'options' => [
                'label' => 'Tags',
                'required' => true,
                'empty_option' => null,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'help-block' => '<ul class="text-info">
                  <li>For Windows & Linux: Hold down the control (ctrl) button to select multiple options</li>
                  <li>For Mac: Hold down the command button to select multiple options</li>
                </ul>'
            ],
            'attributes' => [
                'multiple' => true,
                'size' => 10
            ],
        ]);

        $this->add([
            'name' => 'image',
            'type' => Text::class,
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Image',
                'id' => 'post-image',
            ],
            'options' => [
                'label' => 'Image',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'add-on-append' => new Button('post-image-button', [
                    'label' => 'Add Image',
                ]),
            ],
        ]);

        $this->add([
            'name' => 'layout',
            'type' => Text::class,
            'options' => [
                'label' => 'Layout',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'Layout',
            ],
        ]);

        $this->add([
            'name' => 'lead',
            'type' => Textarea::class,
            'options' => [
                'label' => 'Lead Text',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'Lead Text',
                'id'          => 'news-lead-textarea',
                'rows'        => 10,
            ],
        ]);

        $this->add([
            'name' => 'content',
            'type' => Textarea::class,
            'options' => [
                'label' => 'HTML Content',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'HTML Content',
                'class'       => 'editable-textarea',
                'id'          => 'news-content-textarea',
                'rows'        => 25,
            ],
        ]);

        $this->add([
            'name' => 'dateCreated',
            'type' => DateTime::class,
            'options' => [
                'label' => 'Date Created',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'format' => 'd/m/Y H:i'
            ],
        ]);

        $this->add([
            'name' => 'dateModified',
            'type' => DateTime::class,
            'options' => [
                'label' => 'Date Modified',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'format' => 'd/m/Y H:i'
            ],
            'attributes' => [
                'disabled' => true,
            ]
        ]);

        $this->add([
            'name' => 'postId',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name' => 'userId',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name' => 'security',
            'type' => Csrf::class,
        ]);
    }
} 