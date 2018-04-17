<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 03/04/18 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoBlog\Service;


use UthandoBlog\Options\DisqusOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DisqusOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator): DisqusOptions
    {
        $config     = $serviceLocator->get('config');
        $config     = $config['uthando_blog']['disqus'] ?? [];
        $options    = new DisqusOptions($config);

        return $options;
    }
}
