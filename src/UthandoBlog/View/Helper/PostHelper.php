<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoBlog\View\Helper;

use UthandoBlog\Model\Post as PostModel;
use UthandoBlog\Service\Post as PostService;
use UthandoCommon\Model\ModelInterface;
use UthandoCommon\View\AbstractViewHelper;
use Zend\View\Renderer\PhpRenderer;

/**
 * Class Posts
 *
 * @package UthandoBlog\View\
 * @method PhpRenderer getView()
 */
class PostHelper extends AbstractViewHelper
{
    /**
     * @var PostService
     */
    protected $service;

    public function getLead(PostModel $postModel, int $limit = 0): string
    {
        if ($postModel->getLead()) {
            $lead = $postModel->getLead();
        } else {
            /*$lead = substr(
                $postModel->getContent(),
                3,
                strpos($postModel->getContent(), '</p>') - 3
            );*/
            $lead = str_replace(PHP_EOL, '', $postModel->getContent());
            preg_match('/<p.*?>(.*?)<\/p>/i', $lead, $matches);
            $lead = $matches[1] ?? '';
        }

        if ($limit) {
            $numWords = str_word_count(strip_tags($lead), 1, ',.:?!()1234567890\'"');
            $lead = implode(' ', array_splice($numWords, 0, $limit)) . ' ...';

        }

        return $lead;
    }

    public function getArchiveList()
    {
        return $this->getService()->getArchiveList();
    }

    public function getPopular(int $numPosts = 5)
    {
        return $this->getService()
            ->getPopularPosts($numPosts);
    }

    public function getRecent(int $numPosts = 5)
    {
        return $this->getService()
            ->getRecentPosts($numPosts);
    }

    public function getPrevious($id)
    {
        $prev = $this->getService()->getMapper()
            ->getPrevious($id);

        return $prev;
    }

    /**
     * @param $id
     * @return PostModel|null|ModelInterface
     */
    public function getNext($id)
    {

        $next = $this->getService()->getMapper()
            ->getNext($id);

        return $next;
    }

    public function getService(): PostService
    {
        if (!$this->service instanceof PostService) {

            $service = $this->getServiceLocator()
                ->getServiceLocator()
                ->get('UthandoServiceManager')
                ->get('UthandoBlogPost');
            $this->setService($service);
        }

        return $this->service;
    }

    public function setService(PostService $service): PostHelper
    {
        $this->service = $service;
        return $this;
    }
}