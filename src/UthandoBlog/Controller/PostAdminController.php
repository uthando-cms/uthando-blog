<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoBlog\Controller;

use UthandoBlog\Service\PostService;
use UthandoCommon\Controller\AbstractCrudController;

/**
 * Class PostAdmin
 *
 * @package UthandoBlog\Controller
 */
class PostAdminController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'postId'];
    protected $serviceName = PostService::class;
    protected $route = 'admin/blog/post';
    protected $routes = [
        'edit' => 'admin/blog/post/edit',
    ];
}
