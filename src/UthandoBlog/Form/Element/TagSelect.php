<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 31/08/17 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoBlog\Form\Element;


use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class TagSelect extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    protected $emptyOption = '---Please select tags---';

    public function setOptions($options)
    {
        parent::setOptions($options);

        if (array_key_exists('empty_option', $options)) {
            $this->setEmptyOption($options['empty_option']);
        }
    }

    public function init()
    {
        $zones = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('UthandoServiceManager')
            ->get('UthandoBlogTag')
            ->fetchAll();

        $zoneOptions = [];

        /* @var $zone \UthandoBlog\Model\Tag*/
        foreach($zones as $zone) {
            $zoneOptions[$zone->getTagId()] = $zone->getName();
        }

        $this->setValueOptions($zoneOptions);
    }
}
