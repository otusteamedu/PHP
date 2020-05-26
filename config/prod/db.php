<?php

return [
    'config' => [
        'doctrine' => [
            'connection' => [
                'orm_default' => [
                    'params' => [
                        'url' => 'sqlite::var/db/db_prod.sqlite'
                    ],
                ],
            ],
        ],
    ],
];
