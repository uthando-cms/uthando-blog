<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 09/08/17 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoBlog\Controller;

use UthandoBlog\Options\BlogOptions;
use UthandoBlog\Options\FeedOptions;
use UthandoBlog\Service\PostService;
use UthandoCommon\Service\ServiceTrait;
use Zend\Feed\Writer\Feed as ZendFeed;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\FeedModel;

class FeedController extends AbstractActionController
{
    use ServiceTrait;

    public function __construct()
    {
        $this->setServiceName(PostService::class);
    }

    public function feedAction()
    {
        $options        = $this->getService(BlogOptions::class);
        $feedOptions    = $this->getService(FeedOptions::class);
        $type           = $this->params()->fromRoute('type', null);
        $param          = $this->params()->fromRoute('param', null);
        $post           = [];

        if (null !== $type) {
            $post[$type] = $param;
        }

        $newService = $this->getService();
        $newsItems  = $newService->searchPosts($post, $options->getSortOrder());

        $uri = $this->getRequest()->getUri();
        $base = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());

        $feed = new ZendFeed();
        $feed->setTitle($feedOptions->getTitle());
        $feed->setFeedLink($base . $this->url()->fromRoute('home'), 'atom');

        $feed->setDescription($feedOptions->getDescription());
        $feed->setLink($base . $this->url()->fromRoute('home'));
        $feed->setDateModified(time());

        /* @var \UthandoBlog\Model\PostModel $item */
        foreach ($newsItems as $item) {
            
            $entry = $feed->createEntry();
            $entry->addAuthor([
                'name' => $item->getUser()->getFullName(),
            ]);
            $entry->setTitle($item->getTitle());
            $entry->setLink($base . $this->url()->fromRoute('blog', [
                    'post-item' => $item->getSlug(),
                ]));

            if ($item->getDescription()) {
                $entry->setDescription($item->getDescription());
            }

            $entry->setDateModified($item->getDateModified()->getTimestamp());
            $entry->setDateCreated($item->getDateCreated()->getTimestamp());

            $feed->addEntry($entry);
        }

        $feed->export('rss');

        $feedModel = new FeedModel();
        $feedModel->setFeed($feed);

        return $feedModel;
    }
}