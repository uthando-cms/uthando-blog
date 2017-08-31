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
use UthandoCommon\Model\NestedSet;

/**
 * Class Category
 *
 * @package UthandoBlog\Model
 */
class Category extends NestedSet
{
    use Model;

    /**
     * @var int
     */
    protected $categoryId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $seo;

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     * @return Category
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSeo()
    {
        return $this->seo;
    }

    /**
     * @param $seo
     * @return $this
     */
    public function setSeo($seo)
    {
        $this->seo = $seo;
        return $this;
    }
}