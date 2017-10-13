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
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Expression;
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
        $select->where->equalTo('slug', $slug);

        $rowSet = $this->fetchResult($select);
        $row = $rowSet->current();

        return $row;
    }

    /**
     * @param array $search
     * @param $sort
     * @param array $type
     * @return \Zend\Db\ResultSet\HydratingResultSet|ResultSet|\Zend\Paginator\Paginator
     */
    public function searchPosts(array $search, $sort, $type = [])
    {
        $select = $this->getSelect();
        $select->where->equalTo('status', PostModel::STATUS_PUBLISHED);

        if (!empty($type)) {
            switch ($type[0]) {
                case 'tag':
                    $select->join(
                        'blogPostTag',
                        'blogPost.postId=blogPostTag.postId',
                        [],
                        Select::JOIN_LEFT
                    )->join(
                        'blogTag',
                        'blogPostTag.tagId=blogTag.tagId',
                        [],
                        Select::JOIN_LEFT
                    )->where->equalTo('blogTag.seo', $type[1]);
                    break;
                case 'category':
                    $select->join(
                        'blogCategory',
                        'blogPost.categoryId=blogCategory.categoryId',
                        [],
                        Select::JOIN_LEFT
                    )->where->equalTo('blogCategory.seo', $type[1]);
                    break;
                case 'archive':
                    $select->where
                        ->equalTo(new Expression('MONTH(dateCreated)'), $type[1][0])
                        ->and
                        ->equalTo(new Expression('YEAR(dateCreated)'), $type[1][1]);
                    break;
            }
        }

        return parent::search($search, $sort, $select);
    }

    /**
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getArchiveList()
    {
        $select = $this->getSelect();
        $select->columns([
            'date'          => new Expression("MIN(dateCreated)"),
            'month'         => new Expression("DATE_FORMAT(dateCreated, '%m')"),
            'year'          => new Expression("DATE_FORMAT(dateCreated, '%Y')"),
            'count'         => new Expression("COUNT('" . Select::SQL_STAR . "')"),
        ])->group([
            'year', 'month'
        ])->order([
            'year ' . Select::ORDER_DESCENDING,
            'month ' . Select::ORDER_DESCENDING,
        ])->where->equalTo('status', PostModel::STATUS_PUBLISHED);

        $rowSet = $this->fetchResult($select, new ResultSet());

        return $rowSet;
    }

    /**
     * @param int $limit
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getPostsByHits(int $limit)
    {
        $select = $this->getSelect();
        $select = $this->setLimit($select, $limit, 0);
        $select = $this->setSortOrder($select, '-hits');
        $select->where->equalTo('status' , PostModel::STATUS_PUBLISHED);

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
        $select->where->equalTo('status', PostModel::STATUS_PUBLISHED);

        $rowSet = $this->fetchResult($select);

        return $rowSet;
    }

    public function getPrevious($id, Select $select = null)
    {
        $select = $this->getSql()->select();
        $select->where->equalTo('status', PostModel::STATUS_PUBLISHED);
        return parent::getPrevious($id, $select);
    }

    /**
     * @param $id
     * @param null|Select $select
     * @return null|ModelInterface
     */
    public function getNext($id, Select $select = null)
    {
        $select = $this->getSql()->select();
        $select->where->equalTo('status', PostModel::STATUS_PUBLISHED);
        return parent::getNext($id, $select);
    }
} 