<?php


use App\Services\YouTubeService;
use App\Util\TerminalLogger;
use Elasticsearch\ClientBuilder;


return [
    'redis' => function () {
        $redis = new Redis();
        $redis->connect(
            getenv('REDIS_HOST'), getenv('REDIS_PORT')
        );
        return $redis;
    },
    'elastic' => function () {
        return ClientBuilder::create()
            ->setHosts([getenv('ELASTIC_HOST')])
            ->build();
    },
    TerminalLogger::class => function () {
        return new TerminalLogger();
    },
    YouTubeService::class => function () {
        return new YouTubeService();
    },
];
