<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNews\Options
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2015 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoBlog\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Class NewsOptions
 *
 * @package UthandoNews\Options
 */
class BlogOptions extends AbstractOptions
{
    /**
     * @var string
     */
    protected $sortOrder;

    /**
     * @var int
     */
    protected $itemsPerPage;

    /**
     * @var string
     */
    protected $dateFormat;

    /**
     * @return string
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @param string $sortOrder
     * @return $this
     */
    public function setSortOrder(string $sortOrder): BlogOptions
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

    /**
     * @return int
     */
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * @param int $itemsPerPage
     * @return $this
     */
    public function setItemsPerPage(int $itemsPerPage): BlogOptions
    {
        $this->itemsPerPage = $itemsPerPage;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    /**
     * @param string $dateFormat
     * @return BlogOptions
     */
    public function setDateFormat(string $dateFormat): BlogOptions
    {
        $this->dateFormat = $dateFormat;
        return $this;
    }
}
