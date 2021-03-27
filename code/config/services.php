<?php


use App\Repository\Cache\MemcachedCacheClick;
use App\Repository\Cache\RedisCacheClick;
use App\Services\YouTubeService;
use App\Util\TerminalLogger;
use Elasticsearch\ClientBuilder;
use Psr\Container\ContainerInterface;


return [
    'redis' => function () {
        $redis = new Redis();
        $redis->connect(
            getenv('REDIS_HOST'), getenv('REDIS_PORT')
        );
        return $redis;
    },
    'memcached' => function () {
        $memcached = new Memcached();
        $memcached->addServer(
            getenv('MEMCACHED_HOST'),
            getenv('MEMCACHED_PORT')
        );

        return $memcached;
    },
    'elastic' => function () {
        return ClientBuilder::create()
            ->setHosts([getenv('ELASTIC_HOST')])
            ->build();
    },
    'memcached_click_cache' => function (ContainerInterface $container) {
        return new MemcachedCacheClick($container);
    },
    'redis_click_cache' => function (ContainerInterface $container) {
        return new RedisCacheClick($container);
    },
    TerminalLogger::class => function () {
        return new TerminalLogger();
    },
    YouTubeService::class => function () {
        return new YouTubeService();
    },
];
