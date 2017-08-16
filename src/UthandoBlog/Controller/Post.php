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

use UthandoCommon\Service\ServiceTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class Post
 *
 * @package UthandoBlog\Controller
 * @method \UthandoBlog\Service\Post getService()
 */
class Post extends AbstractActionController
{
    use ServiceTrait;

    public function __construct()
    {
        $this->setServiceName('UthandoPost');
    }

    public function viewAction()
    {
        /* @var \UthandoNews\Options\NewsOptions $options */
        $options = $this->getService('UthandoBlogOptions');
        $search = $this->params()->fromPost('search', null);

        $params = [
            'sort'  => $options->getSortOrder(),
            'count' => $options->getItemsPerPage(),
            'page'  => $this->params()->fromRoute('page'),
            'title-description' => $search,
            //'tag'   => $this->params()->fromRoute('tag'),
        ];

        $service = $this->getService();

        $service->usePaginator([
            'limit' => $params['count'],
            'page' => $params['page'],
        ]);

        $viewModel = new ViewModel([
            'models'    => $service->search($params),
            'view'      => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
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
            $viewModel->setTemplate('uthando-blog/blog/404');
            return $viewModel;
        } else {
            $layout = ($model->getLayout()) ?: 'uthando-news/blog/post-item';
            $viewModel->setTemplate($layout);
        }

        $this->getService()->addPageHit($model);

        return $viewModel->setVariables(['model' => $model]);

    }
} 