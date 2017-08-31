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

use UthandoBlog\Model\Comment as CommentModel;
use UthandoCommon\Hydrator\Strategy\DateTime as DateTimeStrategy;
use UthandoCommon\Hydrator\AbstractHydrator;

/**
 * Class Comment
 * @package UthandoBlog\Hydrator
 */
class Comment extends AbstractHydrator
{
    public function __construct()
    {
        parent::__construct();

        $dateTime = new DateTimeStrategy();

        $this->addStrategy('dateCreated', $dateTime);
        $this->addStrategy('dateModified', $dateTime);

        return $this;
    }

    /**
     * @param CommentModel $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'commentId'     => $object->getCommentId(),
            'postId'        => $object->getPostId(),
            'comment'       => $object->getComment(),
            'author'        => $object->getAuthor(),
            'authorIp'      => $object->getAuthorIp(),
            'email'         => $object->getEmail(),
            'website'       => $object->getWebsite(),
            'approved'      => $object->getAppoved(),
            'lft'           => $object->getLft(),
            'rgt'           => $object->getRgt(),
            'dateCreated'   => $this->extractValue('dateCreated', $object->getDateCreated()),
            'dateModified'  => $this->extractValue('dateModified', $object->getDateModified()),
        ];
    }
}
