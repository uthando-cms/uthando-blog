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
                                'UthandoBlog\Controller\PostAdmin'  => ['action' => 'all'],
                                'UthandoBlog\Controller\Settings'   => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                'UthandoBlog\Controller\Feed',
                'UthandoBlog\Controller\Post',
                'UthandoBlog\Controller\PostAdmin',
                'UthandoBlog\Controller\Settings',
            ],
        ],
    ],
];
