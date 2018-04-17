<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 03/04/18 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoBlog\Options;


use Zend\Stdlib\AbstractOptions;

class DisqusOptions extends AbstractOptions
{
    protected $enabled;
    protected $shortName;
    protected $siteSecretKey;

    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): DisqusOptions
    {
        $this->enabled = $enabled;
        return $this;
    }

    public function getShortName(): string
    {
        return $this->shortName;
    }

    public function setShortName(string $shortName): DisqusOptions
    {
        $this->shortName = $shortName;
        return $this;
    }

    public function getSiteSecretKey(): string
    {
        return $this->siteSecretKey;
    }

    public function setSiteSecretKey(string $siteSecretKey): DisqusOptions
    {
        $this->siteSecretKey = $siteSecretKey;
        return $this;
    }



}
