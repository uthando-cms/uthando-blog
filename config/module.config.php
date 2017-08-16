<?php

return [
    'controllers' => [
        'invokables' => [
            'UthandoBlog\Controller\Feed'       => 'UthandoBlog\Controller\Feed',
            'UthandoBlog\Controller\Post'       => 'UthandoBlog\Controller\Post',
            'UthandoBlog\Controller\PostAdmin'  => 'UthandoBlog\Controller\PostAdmin',
            'UthandoBlog\Controller\Settings'   => 'UthandoBlog\Controller\Settings',
        ],
    ],
    'form_elements' => [
        'invokables' => [
            'UthandoPost'                   => 'UthandoBlog\Form\Post',
            'UthandoBlogFeedFieldSet'       => 'UthandoBlog\Form\BlogFeedFieldSet',
            'UthandoBlogOptionsFieldSet'    => 'UthandoBlog\Form\BlogOptionsFieldSet',
            'UthandoBlogSettings'           => 'UthandoBlog\Form\BlogSettings',
        ],
    ],
    'hydrators' => [
        'invokables' => [
            'UthandoPost' => 'UthandoBlog\Hydrator\Post',
        ],
    ],
    'input_filters' => [
        'invokables' => [
            'UthandoPost' => 'UthandoBlog\InputFilter\Post',
        ],
    ],
    'service_manager' => [
        'factories' => [
            'UthandoBlogFeedOptions'    => 'UthandoBlog\Service\BlogFeedOptionsFactory',
            'UthandoBlogOptions'        => 'UthandoBlog\Service\BlogOptionsFactory',
        ]
    ],
    'uthando_mappers' => [
        'invokables' => [
            'UthandoPost' => 'UthandoBlog\Mapper\Post',
        ],
    ],
    'uthando_models' => [
        'invokables' => [
            'UthandoPost' => 'UthandoBlog\Model\Post',
        ]
    ],
    'uthando_services' => [
        'invokables' => [
            'UthandoPost' => 'UthandoBlog\Service\Post',
        ],
    ],
    'view_helpers' => [
        'invokables' => [
            'PostHelper' => \UthandoBlog\View\Helper\PostHelper::class
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
                                'search'   => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+',
                            ],
                            'defaults'      => [
                                'action'        => 'view',
                                'search'        => '',
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
                    'archives' => [
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
                        'blog-item'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        '__NAMESPACE__' => 'UthandoBlog\Controller',
                        'controller'    => 'Post',
                        'action'        => 'post-item',
                    ],
                ],
            ],
            'blog-feed' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/news/feed',
                    'defaults' => [
                        '__NAMESPACE__' => 'UthandoBlog\Controller',
                        'controller'    => 'Feed',
                        'action'        => 'feed',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_map' => include __DIR__ . '/../template_map.php'
    ],
];