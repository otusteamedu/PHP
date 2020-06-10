<?php

/**
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnreachableStatementInspection
 */

return [
    'appEnv' => 'prod', // prod | dev
    'redis' => [
        'dsn' => '/socks/redis.sock',
    ],
    'amqp' => [
        'host' => 'rabbitmq',
        'port' => '5672',
        'user' => 'guest',
        'pwd' => 'guest',
    ],
    'exchange' => 'local.test',
];
