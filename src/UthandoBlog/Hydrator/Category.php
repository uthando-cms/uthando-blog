<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 18/08/17 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoBlog\Hydrator;

use UthandoBlog\Model\Category as CategoryModel;
use UthandoCommon\Hydrator\AbstractHydrator;

/**
 * Class Category
 * @package UthandoBlog\Hydrator
 */
class Category extends AbstractHydrator
{
    protected $addDepth = false;

    /**
     * @param CategoryModel $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'categoryId'    => $object->getCategoryId(),
            'name'          => $object->getName(),
            'seo'           => $object->getSeo(),
            'lft'           => $object->getLft(),
            'rgt'           => $object->getRgt(),
        ];

        if (true === $this->addDepth) {
            $data['depth'] = $object->getDepth();
        }
    }

    public function addDepth()
    {
        $this->addDepth = true;
    }
}
