<?php


namespace Repetitor202\Application\Clients\SQL\Connections;


use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class ElasticsearchConnection
{
    protected static ?Client $client = null;

    final private function __construct(){}
    final private function __clone(){}
    final private function __wakeup(){}

    final public static function getClient(): ?Client
    {
        if (self::$client === null) {
            self::$client = ClientBuilder::create()
                ->setHosts([$_ENV['ELASTIC_SEARCH_HOST']])
                ->build();
        }

        return self::$client;
    }
}