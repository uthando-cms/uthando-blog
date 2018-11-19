<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 20/08/17 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoBlog\Service;

use UthandoBlog\Form\CommentForm;
use UthandoBlog\Hydrator\CommentHydrator;
use UthandoBlog\InputFilter\CommentInputFilter;
use UthandoBlog\Mapper\CommentMapper;
use UthandoBlog\Model\CommentModel;
use UthandoCommon\Service\AbstractMapperService;

/**
 * Class Comment
 * @package UthandoBlog\Service
 */
class CommentService extends AbstractMapperService
{
    protected $form         = CommentForm::class;
    protected $hydrator     = CommentHydrator::class;
    protected $inputFilter  = CommentInputFilter::class;
    protected $mapper       = CommentMapper::class;
    protected $model        = CommentModel::class;
}