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

use UthandoBlog\Service\TagService;
use UthandoCommon\Controller\AbstractCrudController;

/**
 * Class Tag
 * @package UthandoBlog\Controller
 */
class TagController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'tagId'];
    protected $serviceName = TagService::class;
    protected $route = 'admin/blog/tag';
    protected $routes = [];
}
