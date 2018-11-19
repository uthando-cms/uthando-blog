<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 14/12/17 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoBlog\Controller;


use UthandoBlog\Service\CommentService;
use UthandoCommon\Controller\AbstractCrudController;

class CommentAdminController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'commentId'];
    protected $serviceName = CommentService::class;
    protected $route = 'admin/blog/comment';
    protected $routes = [];
}
