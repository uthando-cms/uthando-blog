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

use UthandoBlog\Model\Tag as TagModel;
use UthandoBlog\Service\Tag as TagService;
use UthandoCommon\View\AbstractViewHelper;
use Zend\Tag\Cloud;

/**
 * Class Tags
 *
 * @package UthandoBlog\View\Helper
 */
class Tags extends AbstractViewHelper
{
    /**
     * @var TagService
     */
    protected $service;

    public function tags(array $tags): string
    {
        $tagArray = [];

        /** @var TagModel $tag */
        foreach ($tags as $tag) {
            $tagArray[] = $this->getView()->escapeHtml($tag->getName());
        }

        return join(', ', $tagArray);
    }

    public function tagLinks(array $tags = null): string
    {
        $html       = '';
        $tagArray   = [];
        $view       = $this->getView();

        /* @var TagModel $tag */
        foreach ($tags as $tag) {
            $tagArray[] = '<a href="' . $view->url('post-list/tag', [
                    'tag' => $view->escapeHtml($tag->getSeo()),
                ]) . '">' . $view->escapeHtml($tag->getName()) . '</a>';
        }

        $html = $html . implode(', ', $tagArray);

        return $html;
    }

    public function tagCloud(): Cloud
    {
        $tags = $this->getService()->getTagCloud();
        $view = $this->getView();

        $tagArray = [
            'cloudDecorator' => [
                'decorator' => 'htmlCloud',
                'options'   => [
                    'htmlTags'    => [
                        'ul' => ['class' => 'list-inline'],
                    ],
                    'separator' => '&nbsp;',
                ],
            ],
            'tagDecorator' => [
                'decorator' => 'htmlTag',
                'options'   => [
                    'minFontSize' => '10',
                    'maxFontSize' => '30',
                    'htmlTags'    => [
                        'li' => ['class' => ''],
                    ],
                ],
            ],
        ];

        foreach ($tags as $tag) {
            $tagArray['tags'][] = [
                'title' => $view->escapeHtml($tag->name),
                'weight' => $view->escapeHtml($tag->count),
                'params' => [
                    'url' => $view->url('post-list/tag', [
                        'tag' => $view->escapeHtml($tag->seo),
                    ]),
                    'title' => $view->escapeHtml($tag->count) . ' topic',
                ],
            ];
        }

        $tagCloud = new Cloud($tagArray);

        return $tagCloud;
    }

    public function getService(): TagService
    {
        if (!$this->service instanceof TagService) {

            $service = $this->getServiceLocator()
                ->getServiceLocator()
                ->get('UthandoServiceManager')
                ->get('UthandoBlogTag');
            $this->setService($service);
        }

        return $this->service;
    }

    public function setService(TagService $service): Tags
    {
        $this->service = $service;
        return $this;
    }
}
