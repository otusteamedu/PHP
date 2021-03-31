<?php


use App\Repository\Cache\MemcachedCacheClick;
use App\Repository\Cache\RedisCacheClick;
use App\Services\Orm\ModelManager;
use App\Services\RedisEventService;
use App\Services\YouTubeService;
use App\Utils\TerminalLogger;
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
    'redis_event_service' => function (ContainerInterface $container) {
        return new RedisEventService($container);
    },
    PDO::class => function () {
        $dsn = sprintf(
            'pgsql:host=%s;port=%d;dbname=%s',
            getenv('DB_HOST'),
            getenv('DB_PORT'),
            getenv('POSTGRES_DB')
        );

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        return new PDO($dsn, getenv('POSTGRES_USER'), getenv('POSTGRES_PASSWORD'), $options);
    },
    ModelManager::class => function (ContainerInterface $container) {
        return new ModelManager($container);
    },
    TerminalLogger::class => function () {
        return new TerminalLogger();
    },
    YouTubeService::class => function () {
        return new YouTubeService();
    },
];
