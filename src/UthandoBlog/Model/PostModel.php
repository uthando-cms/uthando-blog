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

use UthandoCommon\Model\DateCreatedTrait;
use UthandoCommon\Model\DateModifiedTrait;
use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;
use UthandoUser\Model\UserTrait;

/**
 * Class Post
 *
 * @package UthandoBlog\Model
 */
class PostModel implements ModelInterface
{
    const STATUS_DRAFT      = 0;
    const STATUS_PUBLISHED  = 1;

    protected $statusMap = [
        self::STATUS_DRAFT      => 'Draft',
        self::STATUS_PUBLISHED  => 'Published',
    ];

    use Model,
        UserTrait,
        DateCreatedTrait,
        DateModifiedTrait;

    /**
     * @var int
     */
    protected $postId;

    /**
     * @var int
     */
    protected $categoryId;

    /**
     * @var int
     */
    protected $status;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var int
     */
    protected $hits = 0;

    /**
     * @var string
     */
    protected $image;

    /**
     * @var string
     */
    protected $layout;

    /**
     * @var string
     */
    protected $lead;

    /**
     * @var bool
     */
    protected $enableComments;

    /**
     * @var CategoryModel
     */
    protected $category;

    /**
     * @var array
     */
    protected $tags = [];

    /**
     * @return int
     */
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * @param int $postId
     * @return PostModel
     */
    public function setPostId($postId)
    {
        $this->postId = $postId;
        return $this;
    }

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     * @return PostModel
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function getStatusAsString()
    {
        return $this->statusMap[$this->getStatus()];
    }

    /**
     * @param int $status
     * @return PostModel
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return PostModel
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return PostModel
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return PostModel
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return PostModel
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getHits()
    {
        return $this->hits;
    }

    /**
     * @param int $hits
     * @return PostModel
     */
    public function setHits($hits)
    {
        $this->hits = $hits;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return PostModel
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * @param string $layout
     * @return PostModel
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * @return string
     */
    public function getLead()
    {
        return $this->lead;
    }

    /**
     * @param string $lead
     * @return PostModel
     */
    public function setLead($lead)
    {
        $this->lead = $lead;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnableComments()
    {
        return $this->enableComments;
    }

    /**
     * @return bool
     */
    public function getEnableComments()
    {
        return $this->isEnableComments();
    }

    /**
     * @param bool $enableComments
     * @return PostModel
     */
    public function setEnableComments($enableComments)
    {
        $this->enableComments = $enableComments;
        return $this;
    }

    /**
     * @return CategoryModel
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param CategoryModel $category
     * @return PostModel
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     * @return PostModel
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }
}