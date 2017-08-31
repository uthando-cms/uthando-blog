<?php
/**
 * Created by PhpStorm.
 * User: shaun
 * Date: 19/03/2017
 * Time: 21:45
 */

namespace UthandoBlog\Form\Element;

use UthandoCommon\Mapper\AbstractNestedSet;
use Zend\Form\Element\Radio;

class CategoryItemRadio extends Radio
{
    /**
     * init
     */
    public function init()
    {
        $valueOptions = [
            [
                'value' => AbstractNestedSet::INSERT_NO,
                'label' => 'No change.',
                'label_attributes' => [
                    'class' => 'col-md-12',
                ],

            ],
            [
                'value' => AbstractNestedSet::INSERT_NODE,
                'label' => 'Insert after this category.',
                'label_attributes' => [
                    'class' => 'col-md-12',
                ],

            ],
            [
                'value' => AbstractNestedSet::INSERT_CHILD,
                'label' => 'Insert as a sub category.',
                'label_attributes' => [
                    'class' => 'col-md-12',
                ],

            ],
        ];

        $this->setValueOptions($valueOptions);

        $this->setValue(AbstractNestedSet::INSERT_NO);
    }
}
