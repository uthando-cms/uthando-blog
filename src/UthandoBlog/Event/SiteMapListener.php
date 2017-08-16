<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNews\Event
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2015 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoBlog\Event;

use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;

/**
 * Class SiteMapListener
 *
 * @package UthandoBlog\Event
 */
class SiteMapListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    public function attach(EventManagerInterface $events)
    {
        $events = $events->getSharedManager();

        $this->listeners[] = $events->attach([
            'UthandoNavigation\Service\SiteMap',
        ], ['uthando.site-map'], [$this, 'addPages']);
    }

    public function addPages(Event $e)
    {
        /* @var \Zend\Navigation\Navigation $navigation */
        $navigation = $e->getParam('navigation');

        /* @var \UthandoBlog\Service\Post $blogService */
        $blogService = $e->getTarget()->getService('UthandoPost');

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
        $newsPage = $navigation->findOneByRoute('post-list');

        // add categories to shop page
        $newsPage->addPages($menuService->preparePages($pages));

    }
}
