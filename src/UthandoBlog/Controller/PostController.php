<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNews\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoBlog\Controller;

use UthandoBlog\Model\PostModel as PostModel;
use UthandoBlog\Options\BlogOptions;
use UthandoBlog\Service\CategoryService;
use UthandoBlog\Service\PostService;
use UthandoBlog\Service\TagService;
use UthandoCommon\Service\ServiceTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class Post
 *
 * @package UthandoBlog\Controller
 * @method \UthandoBlog\Service\PostService getService()
 */
class PostController extends AbstractActionController
{
    use ServiceTrait;

    public function __construct()
    {
        $this->setServiceName(PostService::class);
    }

    public function viewAction()
    {
        /* @var \UthandoNews\Options\NewsOptions $options */
        $options = $this->getService(BlogOptions::class);
        $search = $this->params()->fromPost('search', null);

        $tag = $this->params()->fromRoute('tag', null);
        $category = $this->params()->fromRoute('category', null);
        $year = $this->params()->fromRoute('year', null);
        $month = $this->params()->fromRoute('month', null);

        $params = [
            'title-description' => $search,
            'tag'               => $tag,
            'category'          => $category,
            'archive'           => [$month, $year],
        ];

        $service = $this->getService();

        if ($tag) {
            $tag = $this->getService(TagService::class)
                ->getTagBySeo($tag);
        }

        if ($category) {
            $category = $this->getService(CategoryService::class)
                ->getCategoryBySeo($category);
        }

        $service->usePaginator([
            'limit' => $options->getItemsPerPage(),
            'page' => $this->params()->fromRoute('page', 1),
        ]);

        $viewModel = new ViewModel([
            'models'    => $service->searchPosts($params, $options->getSortOrder()),
            'view'      => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
            'tag'       => $tag,
            'category'  => $category,
            'archive'   => $year . $month . '01',
        ]);

        if ($this->getRequest()->isXmlHttpRequest()) {
            $viewModel->setTerminal(true);
        }

        return $viewModel;
    }

    public function postItemAction()
    {
        $slug = $this->params()->fromRoute('post-item', null);

        if (null === $slug) {
            return $this->redirect()->toRoute('post-list');
        }

        $viewModel  = new ViewModel();
        $model      = $this->getService()->getBySlug($slug);

        if (!$model) {
            $viewModel->setTemplate('uthando-blog/post/404');
            return $viewModel;
        } else {
            $layout = ($model->getLayout()) ?: 'uthando-blog/post/post-item';
            $viewModel->setTemplate($layout);
        }

        $this->getService()->addPageHit($model);

        return $viewModel->setVariables(['model' => $model]);

    }
} 