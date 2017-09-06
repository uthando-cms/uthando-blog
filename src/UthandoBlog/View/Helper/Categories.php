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

use UthandoBlog\Model\Category;
use UthandoCommon\View\AbstractViewHelper;

/**
 * Class Categories
 *
 * @package UthandoBlog\View\Helper
 */
class Categories extends AbstractViewHelper
{
    public function __invoke(Category $cat)
    {
        $html = '';

        $urlHelper = $this->getView()->plugin('url');

        $html .= '<a href="' . $urlHelper('post-list/category', [
                'category' => $cat->getSeo(),
            ]) . '">' . $cat->getName() . '</a>';

        return $html;
    }
}