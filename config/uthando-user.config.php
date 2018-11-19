<?php

use UthandoBlog\Controller\CategoryController;
use UthandoBlog\Controller\CommentController;
use UthandoBlog\Controller\FeedController;
use UthandoBlog\Controller\PostAdminController;
use UthandoBlog\Controller\PostController;
use UthandoBlog\Controller\SettingsController;
use UthandoBlog\Controller\TagController;

return [
    'uthando_user' => [
        'acl' => [
            'roles' => [
                'guest' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                FeedController::class => ['action' => ['feed']],
                                PostController::class => ['action' => ['view', 'post-item']],
                            ],
                        ],
                    ],
                ],
                'admin' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                CategoryController::class=> ['action' => 'all'],
                                CommentController::class => ['action' => 'all'],
                                PostAdminController::class => ['action' => 'all'],
                                SettingsController::class => ['action' => 'all'],
                                TagController::class => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                CategoryController::class,
                CommentController::class,
                FeedController::class,
                PostAdminController::class,
                PostController::class,
                SettingsController::class,
                TagController::class,
            ],
        ],
    ],
];
