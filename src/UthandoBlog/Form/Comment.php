<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 26/08/17 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoBlog\Form;

use Zend\Form\Element\Csrf;
use Zend\Form\Element\Email;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Element\Url;
use Zend\Form\Form;

/**
 * Class Comment
 * @package UthandoBlog\Form
 */
class Comment extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'author',
            'type' => Text::class,
            'options' => [
                'label' => 'Name',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'Name',
            ],
        ]);

        $this->add([
            'name' => 'url',
            'type' => Url::class,
            'options' => [
                'label' => 'Website',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'Website',
            ],
        ]);

        $this->add([
            'name' => 'email',
            'type' => Email::class,
            'options' => [
                'label' => 'Email',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'Email',
            ],
        ]);

        $this->add([
            'name' => 'content',
            'type' => Textarea::class,
            'options' => [
                'label'     => 'Comment',
                'required'  => true,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'Comment',
            ],
        ]);

        $this->add([
            'name' => 'commentId',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name' => 'PostId',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name' => 'security',
            'type' => Csrf::class,
        ]);
    }
}
