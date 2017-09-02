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
use UthandoCommon\View\AbstractViewHelper;

/**
 * Class Tags
 *
 * @package UthandoBlog\View\Helper
 */
class Tags extends AbstractViewHelper
{
    public function __invoke($tags)
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
}
