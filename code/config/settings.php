<?php
$basePath = dirname(__DIR__);

return [
    'app_name' => 'PHP RabbitMQ',
    'development' => getenv('DEV_MODE'),
    'logger' => [
        'name' => 'app-log',
        'path' => $basePath . '/var/log/app.log',
    ],
    'doctrine' => [
        'isDevMode' => getenv('DEV_MODE'),
        'metadata_dirs' => [
            $basePath . '/src',
        ],
        'connection' => [
            'driver' => 'pdo_pgsql',
            'host' => getenv('DB_HOST'),
            'port' => getenv('DB_PORT'),
            'dbname' => getenv('POSTGRES_DB'),
            'user' => getenv('POSTGRES_USER'),
            'password' => getenv('POSTGRES_PASSWORD'),
        ]
    ],
    'rabbit' => [
        'host' => getenv('RABBITMQ_HOST'),
        'port' => getenv('RABBITMQ_PORT'),
        'user' => getenv('RABBITMQ_DEFAULT_USER'),
        'password' => getenv('RABBITMQ_DEFAULT_PASS'),
    ],
    'queue_name' => 'app-queue',
    'session' => [
        'lifetime' => 3600,
        'path' => '/',
        'domain' => '',
        'security' => false,
        'http_only' => true,
        'name' => 'app-session',
    ],
];
