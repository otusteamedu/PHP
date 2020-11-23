<?php

return [
    'default_queue' => $_ENV['DEFAULT_QUEUE'],
    'queues' => [
        'rabbitmq' => [
            'host'        => $_ENV['RABBITMQ_HOST'] ?? '127.0.0.1',
            'port'        => $_ENV['RABBITMQ_PORT'] ?? 5672,
            'user'        => $_ENV['RABBITMQ_USER'] ?? 'guest',
            'password'    => $_ENV['RABBITMQ_PASSWORD'] ?? 'guest',
            'vhost'       => $_ENV['RABBITMQ_VHOST'] ?? '/',
            'queue'       => $_ENV['RABBITMQ_QUEUE'] ?? 'otus',
            'passive'     => $_ENV['RABBITMQ_PASSIVE'] ?? false,
            'durable'     => $_ENV['RABBITMQ_DURABLE'] ?? true,
            'exclusive'   => $_ENV['RABBITMQ_EXCLUSIVE'] ?? false,
            'auto_delete' => $_ENV['RABBITMQ_AUTO_DELETE'] ?? false,
        ],
    ],
];
