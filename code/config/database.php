<?php


return [
    'postgres' => [
        'driver' => 'pgsql',
        'host' => getenv('DB_HOST'),
        'port' => getenv('DB_PORT'),
        'dbname' => getenv('POSTGRES_DB'),
        'user' => getenv('POSTGRES_USER'),
        'password' => getenv('POSTGRES_PASSWORD')
    ]
];
