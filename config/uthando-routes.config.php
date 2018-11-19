<?php

use UthandoBlog\Controller\CategoryController;
use UthandoBlog\Controller\CommentController;
use UthandoBlog\Controller\PostAdminController;
use UthandoBlog\Controller\SettingsController;
use UthandoBlog\Controller\TagController;

return [
    'router' => [
        'routes' => [
            'admin' => [
                'child_routes' => [
                    'blog' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/blog',
                            'constraints'   => [
                                'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                                '__NAMESPACE__' => 'UthandoBlog\Controller',
                                'controller'    => PostAdminController::class,
                                'action'        => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'post' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/post',
                                    'defaults' => [
                                        'controller' => PostAdminController::class,
                                        'action' => 'index',
                                    ]
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'edit' => [
                                        'type'    => 'Segment',
                                        'options' => [
                                            'route'         => '/[:action[/id/[:id]]]',
                                            'constraints'   => [
                                                'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id'		=> '\d+'
                                            ],
                                            'defaults'      => [
                                                'action'        => 'edit',
                                            ],
                                        ],
                                        'may_terminate' => true,
                                    ],
                                    'page' => [
                                        'type'    => 'Segment',
                                        'options' => [
                                            'route'         => '/page/[:page]',
                                            'constraints'   => [
                                                'page' => '\d+'
                                            ],
                                            'defaults'      => [
                                                'action'        => 'list',
                                                'page'          => 1,
                                            ],
                                        ],
                                        'may_terminate' => true,
                                    ],
                                ],
                            ],
                            'category' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/category',
                                    'defaults' => [
                                        'controller' => CategoryController::class,
                                        'action' => 'index',
                                    ]
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'edit' => [
                                        'type'    => 'Segment',
                                        'options' => [
                                            'route'         => '/[:action[/id/[:id]]]',
                                            'constraints'   => [
                                                'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id'		=> '\d+'
                                            ],
                                            'defaults'      => [
                                                'action'        => 'edit',
                                            ],
                                        ],
                                        'may_terminate' => true,
                                    ],
                                    'page' => [
                                        'type'    => 'Segment',
                                        'options' => [
                                            'route'         => '/page/[:page]',
                                            'constraints'   => [
                                                'page' => '\d+'
                                            ],
                                            'defaults'      => [
                                                'action'        => 'list',
                                                'page'          => 1,
                                            ],
                                        ],
                                        'may_terminate' => true,
                                    ],
                                ],
                            ],
                            'comment' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/comment',
                                    'defaults' => [
                                        'controller' => CommentController::class,
                                        'action' => 'index',
                                    ]
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'edit' => [
                                        'type'    => 'Segment',
                                        'options' => [
                                            'route'         => '/[:action[/id/[:id]]]',
                                            'constraints'   => [
                                                'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id'		=> '\d+'
                                            ],
                                            'defaults'      => [
                                                'action'        => 'edit',
                                            ],
                                        ],
                                        'may_terminate' => true,
                                    ],
                                    'page' => [
                                        'type'    => 'Segment',
                                        'options' => [
                                            'route'         => '/page/[:page]',
                                            'constraints'   => [
                                                'page' => '\d+'
                                            ],
                                            'defaults'      => [
                                                'action'        => 'list',
                                                'page'          => 1,
                                            ],
                                        ],
                                        'may_terminate' => true,
                                    ],
                                ],
                            ],
                            'tag' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/tag',
                                    'defaults' => [
                                        'controller' => TagController::class,
                                        'action' => 'index',
                                    ]
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'edit' => [
                                        'type'    => 'Segment',
                                        'options' => [
                                            'route'         => '/[:action[/id/[:id]]]',
                                            'constraints'   => [
                                                'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id'		=> '\d+'
                                            ],
                                            'defaults'      => [
                                                'action'        => 'edit',
                                            ],
                                        ],
                                        'may_terminate' => true,
                                    ],
                                    'page' => [
                                        'type'    => 'Segment',
                                        'options' => [
                                            'route'         => '/page/[:page]',
                                            'constraints'   => [
                                                'page' => '\d+'
                                            ],
                                            'defaults'      => [
                                                'action'        => 'list',
                                                'page'          => 1,
                                            ],
                                        ],
                                        'may_terminate' => true,
                                    ],
                                ],
                            ],
                            'settings' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/settings',
                                    'defaults' => [
                                        'controller' => SettingsController::class,
                                        'action' => 'index',
                                    ]
                                ],
                                'may_terminate' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
