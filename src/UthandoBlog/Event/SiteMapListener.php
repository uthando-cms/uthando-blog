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

use UthandoNavigation\Service\SiteMap;
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
            SiteMap::class,
        ], 'uthando.site-map', [$this, 'addPages']);
    }

    public function addPages(Event $e)
    {
        /* @var Navigation $navigation */
        $navigation = $e->getParam('navigation');

        /* @var \UthandoBlog\Service\Post $blogService */
        $blogService = $e->getTarget()->getService('UthandoBlogPost');

        /* @var \UthandoNavigation\Service\Menu $menuService */
        $menuService = $e->getTarget()->getService('UthandoNavigationMenu');

        $blogItems = $blogService->search([
            'sort' => '-dateCreated',
        ]);

        $pages = [];

        /* @var \UthandoBlog\Model\Post $blogItem */
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
