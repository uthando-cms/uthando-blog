<?php

return [
    'navigation' => [
        'admin' => [
            'admin' => [
                'pages' => [
                    'settings' => [
                        'pages' => [
                            'blog-settings' => [
                                'label' => 'Blog',
                                'action' => 'index',
                                'route' => 'admin/blog/settings',
                                'resource' => 'menu:admin',
                            ],
                        ],
                    ],
                ],
            ],
            'blog' => [
                'label' => 'Posts',
                'params' => [
                    'icon' => 'fa-edit',
                ],
                'pages' => [
                    'list' => [
                        'label'     => 'List Posts',
                        'action'    => 'index',
                        'route'     => 'admin/blog',
                        'resource'  => 'menu:admin',
                        'visible' => false,
                    ],
                    'add' => [
                        'label'     => 'Add Post',
                        'action'    => 'add',
                        'route'     => 'admin/blog/edit',
                        'resource'  => 'menu:admin',
                        'visible' => false,
                    ],
                    'edit' => [
                        'label'     => 'Edit Post',
                        'action'    => 'edit',
                        'route'     => 'admin/blog/edit',
                        'resource'  => 'menu:admin',
                        'visible' => false,
                    ],
                    'news-settings' => [
                        'label' => 'Settings',
                        'action' => 'index',
                        'route' => 'admin/blog/settings',
                        'resource' => 'menu:admin',
                        'visible' => false,
                    ],
                ],
                'route'     => 'admin/blog',
                'resource'  => 'menu:admin'
            ],
        ],
    ],
];
