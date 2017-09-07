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

    public function tagLinks($tags = null)
    {
        $html       = '';
        $tagArray   = [];

        $urlHelper = $this->getView()->plugin('url');

        /* @var TagModel $tag */
        foreach ($tags as $tag) {
            $tagArray[] = '<a href="' . $urlHelper('post-list/tag', [
                    'tag' => $tag->getSeo(),
                ]) . '">' . $tag->getName() . '</a>';
        }

        $html = $html . implode(', ', $tagArray);

        return $html;
    }

    public function tagCloud()
    {
        $tags = $this->getService()->getTagCloud();
        $urlHelper = $this->getView()->plugin('url');

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
                'title' => $tag->name,
                'weight' => $tag->count,
                'params' => [
                    'url' => $urlHelper('post-list/tag', [
                        'tag' => $tag->seo,
                    ]),
                    'title' => $tag->count . ' topic',
                ],
            ];
        }

        $tagCloud = new Cloud($tagArray);

        return $tagCloud;
    }

    /**
     * @return TagService
     */
    public function getService()
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

    /**
     * @param TagService $service
     * @return $this
     */
    public function setService(TagService $service)
    {
        $this->service = $service;
        return $this;
    }
}
