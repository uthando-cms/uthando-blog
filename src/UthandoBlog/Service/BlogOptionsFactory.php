<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNews\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2015 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoBlog\Service;

use UthandoBlog\Options\BlogOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BlogOptionsFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return BlogOptions
     */
    public function createService(ServiceLocatorInterface $serviceLocator) : BlogOptions
    {
        $config     = $serviceLocator->get('config');
        $config     = $config['uthando_blog']['options'] ?? [];
        $options    = new BlogOptions($config);

        return $options;
    }
}
