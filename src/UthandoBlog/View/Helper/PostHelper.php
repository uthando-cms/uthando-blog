<?php
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

/**
 * Class Posts
 *
 * @package UthandoBlog\View\Helper
 */
class PostHelper extends AbstractViewHelper
{
    /**
     * @var PostService
     */
    protected $service;

    /**
     * @return PostHelper
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getPopular()
    {
        return $this->getService()
            ->getPopularPosts(5);
    }

    /**
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getRecent()
    {
        return $this->getService()
            ->getRecentPosts(5);
    }

    /**
     * @param $id
     * @return PostModel|null|ModelInterface
     */
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

    /**
     * @return PostService
     */
    public function getService()
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

    /**
     * @param PostService $service
     * @return PostHelper
     */
    public function setService(PostService $service)
    {
        $this->service = $service;
        return $this;
    }
}