<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 28/08/17 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoBlog\Form;


use Zend\Form\Element\Csrf;
use Zend\Form\Form;

/**
 * Class Tag
 * @package UthandoBlog\Form
 */
class Tag extends Form
{
    public function init()
    {
        $this->add([
            'type' => TagFieldSet::class,
            'name' => 'tags',
            'options' => [
                'label' => 'Tags',
                'use_as_base_fieldset' => true,
            ],
            'attributes' => [
                'class' => 'col-md-12',
            ],
        ]);

        $this->add([
            'name' => 'security',
            'type' => Csrf::class,
        ]);
    }
}
