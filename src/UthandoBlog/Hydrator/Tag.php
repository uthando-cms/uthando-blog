<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 20/08/17 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoBlog\Hydrator;

use UthandoBlog\Model\Tag as TagModel;
use UthandoCommon\Hydrator\AbstractHydrator;

/**
 * Class Tag
 * @package UthandoBlog\Hydrator
 */
class Tag extends AbstractHydrator
{
    /**
     * @param TagModel $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'tagId' => $object->getTag(),
            'tag'   => $object->getTag(),
            'seo'   => $object->getSeo(),
        ];
    }
}
