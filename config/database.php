<?php
return [
    'connection'  => env('DB_DRIVER', 'pgsql'),
    'default'     => 'pgsql',
    'connections' => [
        'pgsql' => [
            'driver'   => 'pgsql',
            'host'     => env('DB_HOST', '127.0.0.1'),
            'port'     => env('DB_PORT', 5432),
            'database' => env('DB_NAME'),
            'username' => env('DB_USER'),
            'password' => env('DB_PASSWORD')
        ]
    ],
    'migrations' => 'migrations'
];