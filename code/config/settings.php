<?php
$basePath = dirname(__DIR__);

return [
    'app_name' => 'PHP RabbitMQ',
    'development' => getenv('DEV_MODE'),
    'queue_name' => 'app-queue',
    'templates_path' => $basePath . '/src/templates',
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
    'session' => [
        'lifetime' => 3600,
        'path' => '/',
        'domain' => '',
        'security' => false,
        'http_only' => true,
        'name' => 'app-session',
    ],
    'smtp' => [
        'host' => getenv('SMTP_HOST'),
        'port' => getenv('SMTP_PORT'),
        'username' => getenv('SMTP_USERNAME'),
        'password' => getenv('SMTP_PASSWORD'),
    ]
];
