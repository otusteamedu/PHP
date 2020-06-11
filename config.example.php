<?php

/**
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnreachableStatementInspection
 */

use App\App;
use App\Domain\PublisherInterface;

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
    'pipeline' => 'local',
    PublisherInterface::class => static function () {
        //return App::get(\App\Domain\PublisherRPC::class);
        return App::get(\App\Domain\PublisherAMQP::class);
    },
];
