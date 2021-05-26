<?php
$basePath = dirname(__DIR__);

return [
    'app_name' => 'PHP RabbitMQ',
    'development' => getenv('DEV_MODE'),
    'doctrine' => [
        'isDevMode' => getenv('DEV_MODE'),
        'metadata_dirs' => [
            $basePath . '/src',
        ],
        'connection' => [
            'driver' => 'pdo_pgsql',
            'host' => getenv('DB_HOST'),
            'port' => getenv('DB_PORT'),
            'dbname' => getenv('POSTGRES_DB_TEST'),
            'user' => getenv('POSTGRES_USER'),
            'password' => getenv('POSTGRES_PASSWORD'),
        ]
    ],
];
