<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 18/08/17 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoBlog\Mapper;

use UthandoCommon\Mapper\AbstractNestedSet;

/**
 * Class Category
 * @package UthandoBlog\Mapper
 */
class CategoryMapper extends AbstractNestedSet
{
    protected $table = 'blogCategory';
    protected $primary = 'categoryId';

    /**
     * @param array $search
     * @param string $sort
     * @param Select $select
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function search(array $search, $sort, $select = null)
    {
        $select = $this->getFullTree();
        return parent::search($search, $sort, $select);
    }

    public function getCategoryBySeo($seo)
    {
        $seo = (string) $seo;
        $select = $this->getSelect();
        $select->where->equalTo('seo', $seo);
        $result = $this->fetchResult($select);

        return $result->current();
    }
}