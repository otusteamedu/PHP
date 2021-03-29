<?php

namespace App\Services\ElasticSearch;

use Elasticsearch\ClientBuilder;
use Elasticsearch\Client;

class ElasticSearchClient
{
    private ?Client $client = null;
    private static ?self $instance = null;

    private function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['http://es01:9200'])
            ->build();
    }

    public static function get(): Client
    {
        if(is_null(self::$instance)){
            self::$instance = new self();
        }

        return self::$instance->client;
    }
}