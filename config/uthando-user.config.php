<?php

return [
    'uthando_user' => [
        'acl' => [
            'roles' => [
                'guest' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                'UthandoBlog\Controller\Feed' => ['action' => ['feed']],
                                'UthandoBlog\Controller\Post' => ['action' => ['view', 'post-item']],
                            ],
                        ],
                    ],
                ],
                'admin' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                'UthandoBlog\Controller\Category'   => ['action' => 'all'],
                                'UthandoBlog\Controller\Comment'    => ['action' => 'all'],
                                'UthandoBlog\Controller\PostAdmin'  => ['action' => 'all'],
                                'UthandoBlog\Controller\Settings'   => ['action' => 'all'],
                                'UthandoBlog\Controller\Tag'        => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                'UthandoBlog\Controller\Category',
                'UthandoBlog\Controller\Comment',
                'UthandoBlog\Controller\Feed',
                'UthandoBlog\Controller\Post',
                'UthandoBlog\Controller\PostAdmin',
                'UthandoBlog\Controller\Settings',
                'UthandoBlog\Controller\Tag',
            ],
        ],
    ],
];
