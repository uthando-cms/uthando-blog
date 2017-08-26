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

use UthandoCommon\Mapper\AbstractDbMapper;

/**
 * Class Tag
 * @package UthandoBlog\Mapper
 */
class Tag extends AbstractDbMapper
{
    protected $table = 'blogTag';
    protected  $primary = 'tagId';
}