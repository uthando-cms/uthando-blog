<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 18/08/17 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoBlog\Mapper;

use UthandoCommon\Mapper\AbstractNestedSet;

/**
 * Class Category
 * @package UthandoBlog\Mapper
 */
class Category extends AbstractNestedSet
{
    protected $table = 'blogCategory';
    protected $primary = 'categoryId';
}