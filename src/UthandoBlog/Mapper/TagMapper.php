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

use UthandoBlog\Model\PostModel as PostModel;
use UthandoCommon\Mapper\AbstractDbMapper;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;

/**
 * Class Tag
 * @package UthandoBlog\Mapper
 */
class TagMapper extends AbstractDbMapper
{
    protected $table = 'blogTag';
    protected  $primary = 'tagId';

    /**
     * @param $id
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getTagsByPostId($id)
    {
        $id = (int) $id;
        $select = $this->getSelect();
        $select->join(
            'blogPostTag',
            'blogTag.tagId=blogPostTag.tagId',
            [],
            Select::JOIN_LEFT
        )->where->equalTo('blogPostTag.postId', $id);

        return $this->fetchResult($select);
    }

    public function getTagBySeo($seo)
    {
        $seo = (string) $seo;
        $select = $this->getSelect();
        $select->where->equalTo('seo', $seo);
        $result = $this->fetchResult($select);

        return $result->current();
    }

    /**
     * @return \Zend\Db\ResultSet\HydratingResultSet|ResultSet|\Zend\Paginator\Paginator
     */
    public function getTagCloud()
    {
        $select = $this->getSelect();

        $select->columns([
            'name',
            'seo',
            'count' => new Expression("COUNT('" . Select::SQL_STAR . "')"),
        ])->join(
            'blogPostTag',
            'blogTag.tagId=blogPostTag.tagId',
            [],
            Select::JOIN_LEFT
        )->join(
            'blogPost',
            'blogPostTag.postId=blogPost.postId',
            [],
            Select::JOIN_LEFT
        )->group([
            'name', 'seo'
        ])->order([
            'name ' . Select::ORDER_ASCENDING,
        ])->where->equalTo(
            'status', PostModel::STATUS_PUBLISHED
        );

        $result = $this->fetchResult($select, new ResultSet());

        return $result;
    }
}