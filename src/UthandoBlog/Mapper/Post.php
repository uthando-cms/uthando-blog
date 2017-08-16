<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 * 
 * @package   UthandoNews\Mapper
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoBlog\Mapper;

use UthandoCommon\Mapper\AbstractDbMapper;
use UthandoBlog\Model\Post as PostModel;
use Zend\Db\Sql\Select;

/**
 * Class Blog
 *
 * @package UthandoBlog\Mapper
 */
class Post extends AbstractDbMapper
{
    protected $table = 'blogPost';
    protected $primary = 'postId';

    /**
     * @param $slug
     * @return null|PostModel
     */
    public function getBySlug($slug)
    {
        $select = $this->getSelect();
        $select->where(['slug' => $slug]);

        $rowSet = $this->fetchResult($select);
        $row = $rowSet->current();

        return $row;
    }

    /**
     * @param array $search
     * @param string $sort
     * @param null $select
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function search(array $search, $sort, $select = null)
    {
        $select = $this->getSelect();
    
        return parent::search($search, $sort, $select);
    }

    /**
     * @param int $limit
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getPostsByHits(int $limit)
    {
        $select = $this->getSelect();
        $select = $this->setLimit($select, $limit, 0);
        $select = $this->setSortOrder($select, '-pageHits');

        $rowSet = $this->fetchResult($select);

        return $rowSet;
    }

    /**
     * @param int $limit
     * @param string $sort
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getPostsByDate(int $limit, string $sort = '-')
    {
        $select = $this->getSelect();
        $select = $this->setLimit($select, $limit, 0);
        $select = $this->setSortOrder($select, $sort . 'dateCreated');

        $rowSet = $this->fetchResult($select);

        return $rowSet;
    }
} 