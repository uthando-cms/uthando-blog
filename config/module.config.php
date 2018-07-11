<?php

use UthandoBlog\Options\BlogOptions;
use UthandoBlog\Options\DisqusOptions;
use UthandoBlog\Service\BlogOptionsFactory;
use UthandoBlog\Service\DisqusOptionsFactory;
use UthandoBlog\View\Helper\Categories;
use UthandoBlog\View\Helper\Comments;
use UthandoBlog\View\Helper\PostHelper;
use UthandoBlog\View\Helper\Tags;

return [
    'controllers' => [
        'invokables' => [
            'UthandoBlog\Controller\Category'   => 'UthandoBlog\Controller\Category',
            'UthandoBlog\Controller\Comment'    => 'UthandoBlog\Controller\Comment',
            'UthandoBlog\Controller\Feed'       => 'UthandoBlog\Controller\Feed',
            'UthandoBlog\Controller\Post'       => 'UthandoBlog\Controller\Post',
            'UthandoBlog\Controller\PostAdmin'  => 'UthandoBlog\Controller\PostAdmin',
            'UthandoBlog\Controller\Settings'   => 'UthandoBlog\Controller\Settings',
            'UthandoBlog\Controller\Tag'        => 'UthandoBlog\Controller\Tag',
        ],
    ],
    'form_elements' => [
        'invokables' => [
            'UthandoBlogCategory'           => 'UthandoBlog\Form\Category',
            'UthandoBlogComment'            => 'UthandoBlog\Form\Comment',
            'UthandoBlogPost'               => 'UthandoBlog\Form\Post',
            'UthandoBlogTag'                => 'UthandoBlog\Form\Tag',
            'UthandoBlogFeedFieldSet'       => 'UthandoBlog\Form\BlogFeedFieldSet',
            'UthandoBlogOptionsFieldSet'    => 'UthandoBlog\Form\BlogOptionsFieldSet',
            'UthandoBlogSettings'           => 'UthandoBlog\Form\BlogSettings',
        ],
    ],
    'hydrators' => [
        'invokables' => [
            'UthandoBlogCategory'   => 'UthandoBlog\Hydrator\Category',
            'UthandoBlogComment'    => 'UthandoBlog\Hydrator\Comment',
            'UthandoBlogPost'       => 'UthandoBlog\Hydrator\Post',
            'UthandoBlogTag'        => 'UthandoBlog\Hydrator\Tag',
        ],
    ],
    'input_filters' => [
        'invokables' => [
            'UthandoBlogCategory'   => 'UthandoBlog\InputFilter\Category',
            'UthandoBlogComment'    => 'UthandoBlog\InputFilter\Comment',
            'UthandoBlogPost'       => 'UthandoBlog\InputFilter\Post',
            'UthandoBlogTag'        => 'UthandoBlog\InputFilter\Tag',
        ],
    ],
    'service_manager' => [
        'aliases' => [
            'UthandoBlogOptions'        => BlogOptions::class,
        ],
        'factories' => [
            'UthandoBlogFeedOptions'    => 'UthandoBlog\Service\BlogFeedOptionsFactory',

            BlogOptions::class          => BlogOptionsFactory::class,
            DisqusOptions::class        => DisqusOptionsFactory::class,
        ]
    ],
    'uthando_mappers' => [
        'invokables' => [
            'UthandoBlogCategory'   => 'UthandoBlog\Mapper\Category',
            'UthandoBlogComment'    => 'UthandoBlog\Mapper\Comment',
            'UthandoBlogPost'       => 'UthandoBlog\Mapper\Post',
            'UthandoBlogTag'        => 'UthandoBlog\Mapper\Tag',

        ],
    ],
    'uthando_models' => [
        'invokables' => [
            'UthandoBlogCategory'   => 'UthandoBlog\Model\Category',
            'UthandoBlogComment'    => 'UthandoBlog\Model\Comment',
            'UthandoBlogPost'       => 'UthandoBlog\Model\Post',
            'UthandoBlogTag'        => 'UthandoBlog\Model\Tag',
        ]
    ],
    'uthando_services' => [
        'invokables' => [
            'UthandoBlogCategory'   => 'UthandoBlog\Service\Category',
            'UthandoBlogComment'    => 'UthandoBlog\Service\Comment',
            'UthandoBlogPost'       => 'UthandoBlog\Service\Post',
            'UthandoBlogTag'        => 'UthandoBlog\Service\Tag',
        ],
    ],
    'view_helpers' => [
        'invokables' => [
            'CategoryHelper'    => Categories::class,
            'CommentHelper'     => Comments::class,
            'PostHelper'        => PostHelper::class,
            'TagHelper'         => Tags::class
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
                        'controller'    => 'Post',
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
                        'controller'    => 'Post',
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
                        'controller'    => 'Feed',
                        'action'        => 'feed',
                    ],
                ],
            ],
        ],
    ],
];