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


use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;
use Zend\Form\Form;

/**
 * Class Category
 * @package UthandoBlog\Form
 */
class Category extends Form
{
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
            'placeholder' => 'Category Name',
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
}