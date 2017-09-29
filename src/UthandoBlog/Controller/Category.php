<?php declare(strict_types=1);
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
 * Class Category
 * @package UthandoBlog\Controller
 */
class Category extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'lft'];
    protected $serviceName = 'UthandoBlogCategory';
    protected $route = 'admin/blog/category';
    protected $routes = [];
}
