<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoBlog\Model;

use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

/**
 * Class Tag
 *
 * @package UthandoBlog\Model
 */
class Tag implements ModelInterface
{
    use Model;

    /**
     * @var int
     */
    protected $tagId;

    /**
     * @var string
     */
    protected $tag;

    /**
     * @return int
     */
    public function getTagId()
    {
        return $this->tagId;
    }

    /**
     * @param int $tagId
     * @return Tag
     */
    public function setTagId($tagId)
    {
        $this->tagId = $tagId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     * @return Tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
        return $this;
    }
}