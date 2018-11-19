<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 * 
 * @package   UthandoBlog
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoBlog;

use UthandoBlog\Event\SiteMapListener;
use UthandoCommon\Config\ConfigInterface;
use UthandoCommon\Config\ConfigTrait;
use Zend\Mvc\MvcEvent;

/**
 * Class Module
 * @package UthandoBlog
 */
class Module implements ConfigInterface
{
    use ConfigTrait;

    public function onBootStrap(MvcEvent $e): void
    {
        $app            = $e->getApplication();
        $eventManager   = $app->getEventManager();
        $event          = new SiteMapListener();

        $event->attach($eventManager);
    }

    public function getConfig(): array
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig(): array
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }
} 