<?php


use App\Services\YouTubeService;
use App\Util\TerminalLogger;
use Elasticsearch\ClientBuilder;


return [
    YouTubeService::class => function () {
        return new YouTubeService();
    },
    'elastic' => function () {
        return ClientBuilder::create()
            ->setHosts([getenv('ELASTIC_HOST')])
            ->build();
    },
    TerminalLogger::class => function () {
        return new TerminalLogger();
    }
];
