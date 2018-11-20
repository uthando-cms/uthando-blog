<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNews\Event
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2015 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoBlog\Event;

use UthandoBlog\Service\PostService;
use UthandoNavigation\Service\MenuService;
use UthandoNavigation\Service\SiteMapService;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Navigation\Navigation;

/**
 * Class SiteMapListener
 *
 * @package UthandoBlog\Event
 */
class SiteMapListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    public function attach(EventManagerInterface $events): void
    {
        $events = $events->getSharedManager();

        $this->listeners[] = $events->attach([
            SiteMapService::class,
        ], 'uthando.site-map', [$this, 'addPages']);
    }

    public function addPages(Event $e)
    {
        /* @var Navigation $navigation */
        $navigation = $e->getParam('navigation');

        /* @var \UthandoBlog\Service\PostService $blogService */
        $blogService = $e->getTarget()->getService(PostService::class);

        /* @var \UthandoNavigation\Service\MenuService $menuService */
        $menuService = $e->getTarget()->getService(MenuService::class);

        $blogItems = $blogService->searchPosts([], '-dateCreated');

        $pages = [];

        /* @var \UthandoBlog\Model\PostModel $blogItem */
        foreach ($blogItems as $blogItem) {
            $pages[$blogItem->getSlug()] = [
                'label'     => $blogItem->getTitle(),
                'route'     => 'blog',
                'params'    => [
                    'post-item' => $blogItem->getSlug(),
                ],
            ];
        }

        // find shop page
        $newsPage = $navigation->findOneBy('route','post-list');

        // add categories to shop page
        $newsPage->addPages($menuService->preparePages($pages));

    }
}
