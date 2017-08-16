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
    protected $category;
}