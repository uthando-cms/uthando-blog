<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   ${NAMESPACE}
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoBlogTest\Model;

use UthandoBlog\Model\PostModel;
use UthandoBlogTest\Framework\TestCase;

class PostTest extends TestCase
{

    public function testGetPostId()
    {
        $post = new PostModel();
        $post->setPostId(1);

        $this->assertSame(1, $post->getPostId());

    }
}
