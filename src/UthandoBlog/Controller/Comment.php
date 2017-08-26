<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 22/08/17 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoBlog\Controller;

use UthandoCommon\Controller\AbstractCrudController;

/**
 * Class Comment
 * @package UthandoBlog\Controller
 */
class Comment extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'commentId'];
    protected $serviceName = 'UthandoBlogComment';
    protected $route = 'admin/blog/comment';
    protected $routes = [];
}
