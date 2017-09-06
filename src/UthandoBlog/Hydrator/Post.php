<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 * 
 * @package   UthandoNews\Hydrator
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoBlog\Hydrator;

use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\DateTime as DateTimeStrategy;
use UthandoBlog\Model\Post as PostModel;
use UthandoCommon\Hydrator\Strategy\NullStrategy;

/**
 * Class Blog
 *
 * @package UthandoBlog\Hydrator
 */
class Post extends AbstractHydrator
{
    public function __construct()
    {
        parent::__construct();

        $dateTime = new DateTimeStrategy();

        $this->addStrategy('dateCreated', $dateTime);
        $this->addStrategy('dateModified', $dateTime);
        $this->addStrategy('categoryId', new NullStrategy());

        return $this;
    }

    /**
     * Extract values from an object
     *
     * @param PostModel $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'postId'        => $object->getPostId(),
            'userId'        => $object->getUserId(),
            'categoryId'    => $this->extractValue('categoryId',$object->getCategoryId()),
            'title'         => $object->getTitle(),
            'slug'          => $object->getSlug(),
            'content'       => $object->getContent(),
            'description'   => $object->getDescription(),
            'hits'          => $object->getHits(),
            'image'         => $object->getImage(),
            'layout'        => $object->getLayout(),
            'lead'          => $object->getLead(),
            'dateCreated'   => $this->extractValue('dateCreated', $object->getDateCreated()),
            'dateModified'  => $this->extractValue('dateModified', $object->getDateModified()),
            'status'        => $object->getStatus(),
        ];
    }
}
