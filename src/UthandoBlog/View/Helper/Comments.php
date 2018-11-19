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

use UthandoBlog\Model\PostModel;
use UthandoCommon\View\AbstractViewHelper;


/**
 * Class Comments
 *
 * @package UthandoBlog\View\Helper
 */
class Comments extends AbstractViewHelper
{
    public function disqus(PostModel $post): string
    {
        $config = $this->getConfig('uthando_blog');
        $enabled = false;

        if ($config['disqus']['enabled']) {
            $enabled = $post->isEnableComments();
        }

        if ($enabled) {
            return $this->getView()->partial(
                'uthando-blog/comment/disqus', [
                'shortName' => $config['disqus']['short_name'],
                'post'      => $post,
            ]);
        }

        return '';
    }
}