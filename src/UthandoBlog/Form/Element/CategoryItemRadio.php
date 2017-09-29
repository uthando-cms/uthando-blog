<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 26/08/17 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoBlog\Form\Element;

use UthandoCommon\Mapper\AbstractNestedSet;
use Zend\Form\Element\Radio;

class CategoryItemRadio extends Radio
{
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
