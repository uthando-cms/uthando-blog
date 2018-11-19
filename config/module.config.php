<?php

use UthandoBlog\Controller\CategoryController;
use UthandoBlog\Controller\CommentController;
use UthandoBlog\Controller\FeedController;
use UthandoBlog\Controller\PostAdminController;
use UthandoBlog\Controller\PostController;
use UthandoBlog\Controller\SettingsController;
use UthandoBlog\Controller\TagController;
use UthandoBlog\Options\BlogOptions;
use UthandoBlog\Options\DisqusOptions;
use UthandoBlog\Options\FeedOptions;
use UthandoBlog\Service\BlogFeedOptionsFactory;
use UthandoBlog\Service\BlogOptionsFactory;
use UthandoBlog\Service\CategoryService;
use UthandoBlog\Service\CommentService;
use UthandoBlog\Service\DisqusOptionsFactory;
use UthandoBlog\Service\PostService;
use UthandoBlog\Service\TagService;
use UthandoBlog\View\Helper\Categories;
use UthandoBlog\View\Helper\Comments;
use UthandoBlog\View\Helper\PostHelper;
use UthandoBlog\View\Helper\Tags;

return [
    'controllers' => [
        'invokables' => [
            CategoryController::class   => CategoryController::class,
            CommentController::class    => CommentController::class,
            FeedController::class       => FeedController::class,
            PostController::class       => PostController::class,
            PostAdminController::class  => PostAdminController::class,
            PostController::class       => PostController::class,
            SettingsController::class   => SettingsController::class,
            TagController::class        => TagController::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            BlogOptions::class      => BlogOptionsFactory::class,
            DisqusOptions::class    => DisqusOptionsFactory::class,
            FeedOptions::class      => BlogFeedOptionsFactory::class,
        ]
    ],
    'uthando_services' => [
        'invokables' => [
            CategoryService::class  => CategoryService::class,
            CommentService::class   => CommentService::class,
            PostService::class      => PostService::class,
            TagService::class       => TagService::class,
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'CategoryHelper'    => Categories::class,
            'CommentHelper'     => Comments::class,
            'PostHelper'        => PostHelper::class,
            'TagHelper'         => Tags::class
        ],
        'invokables' => [
            Categories::class   => Categories::class,
            Comments::class     => Comments::class,
            PostHelper::class   => PostHelper::class,
            Tags::class         => Tags::class
        ],
    ],
    'view_manager' => [
        'strategies' => [
            'ViewFeedStrategy',
        ],
        'template_map' => include __DIR__ . '/../template_map.php'
    ],
    'router' => [
        'routes' => [
            'post-list' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/blog',
                    'defaults' => [
                        '__NAMESPACE__' => 'UthandoBlog\Controller',
                        'controller'    => PostController::class,
                        'action'        => 'view',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'search' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'         => '/search/[:search][/[:page]]',
                            'constraints'   => [
                                'search'   => '[a-zA-Z][a-zA-Z0-9_-]',
                                'page' => '\d+',
                            ],
                            'defaults'      => [
                                'action'        => 'view',
                                'search'        => '',
                                'page'          => 1,
                            ],
                        ],
                    ],
                    'category' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'         => '/category/[:category][/[:page]]',
                            'constraints'   => [
                                'category'   => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+',
                            ],
                            'defaults'      => [
                                'action'        => 'view',
                                'tag'           => '',
                                'page'          => 1,
                            ],
                        ],
                    ],
                    'tag' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'         => '/tag/[:tag][/[:page]]',
                            'constraints'   => [
                                'tag'   => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+',
                            ],
                            'defaults'      => [
                                'action'        => 'view',
                                'tag'           => '',
                                'page'          => 1,
                            ],
                        ],
                    ],
                    'archive' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'         => '/[:year]/[:month][/[:page]]',
                            'constraints'   => [
                                'year' => '\d+',
                                'month' => '\d+',
                                'page' => '\d+',
                            ],
                            'defaults'      => [
                                'action'     => 'view',
                                'page'       => 1,
                            ],
                        ],
                    ],
                    'page' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'         => '/[:page]',
                            'constraints'   => [
                                'page' => '\d+',
                            ],
                            'defaults'      => [
                                'action'        => 'view',
                                'page'          => 1,
                            ],
                        ],
                    ],
                ],
            ],
            'blog' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/blog/[:post-item]',
                    'constraints' => [
                        'post-item'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        '__NAMESPACE__' => 'UthandoBlog\Controller',
                        'controller'    => PostController::class,
                        'action'        => 'post-item',
                    ],
                ],
            ],
            'blog-feed' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/blog/feed[/[:type]/[:param]]',
                    'constraints' => [
                        'type'  => 'category|tag',
                        'param'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        '__NAMESPACE__' => 'UthandoBlog\Controller',
                        'controller'    => FeedController::class,
                        'action'        => 'feed',
                    ],
                ],
            ],
        ],
    ],
];