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
                'label' => 'Blog',
                'params' => [
                    'icon' => 'fa-edit',
                ],
                'pages' => [
                    'list' => [
                        'label'     => 'Posts',
                        'action'    => 'index',
                        'route'     => 'admin/blog/post',
                        'resource'  => 'menu:admin',
                        'visible' => true,
                    ],
                    'add' => [
                        'label'     => 'Add Post',
                        'action'    => 'add',
                        'route'     => 'admin/blog/post/edit',
                        'resource'  => 'menu:admin',
                        'visible' => false,
                    ],
                    'edit' => [
                        'label'     => 'Edit Post',
                        'action'    => 'edit',
                        'route'     => 'admin/blog/post/edit',
                        'resource'  => 'menu:admin',
                        'visible' => false,
                    ],
                    'category' => [
                        'label' => 'Categories',
                        'route' => 'admin/blog/category',
                        'resource' => 'menu:admin',
                        'pages' => [
                            'add' => [
                                'label'     => 'Add Category',
                                'action'    => 'add',
                                'route'     => 'admin/blog/category/edit',
                                'resource'  => 'menu:admin',
                                'visible' => false,
                            ],
                            'edit' => [
                                'label'     => 'Edit Category',
                                'action'    => 'edit',
                                'route'     => 'admin/blog/category/edit',
                                'resource'  => 'menu:admin',
                                'visible' => false,
                            ],
                        ],
                    ],
                    'comment' => [
                        'label' => 'Comments',
                        'route' => 'admin/blog/comment',
                        'resource' => 'menu:admin',
                        'visible' => false,
                        'pages' => [
                            'add' => [
                                'label'     => 'Add Comment',
                                'action'    => 'add',
                                'route'     => 'admin/blog/comment/edit',
                                'resource'  => 'menu:admin',
                                'visible' => false,
                            ],
                            'edit' => [
                                'label'     => 'Edit Comment',
                                'action'    => 'edit',
                                'route'     => 'admin/blog/comment/edit',
                                'resource'  => 'menu:admin',
                                'visible' => false,
                            ],
                        ],
                    ],
                    'tag' => [
                        'label' => 'Tags',
                        'route' => 'admin/blog/tag',
                        'resource' => 'menu:admin',
                        'pages' => [
                            'add' => [
                                'label'     => 'Add Tag',
                                'action'    => 'add',
                                'route'     => 'admin/blog/tag/edit',
                                'resource'  => 'menu:admin',
                                'visible' => false,
                            ],
                            'edit' => [
                                'label'     => 'Edit Tag',
                                'action'    => 'edit',
                                'route'     => 'admin/blog/tag/edit',
                                'resource'  => 'menu:admin',
                                'visible' => false,
                            ],
                        ],
                    ],
                    'blog-settings' => [
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
