<?php

namespace Otus;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class ElasticClientFactory
{
    public static function make(): Client
    {
        $config = require __DIR__.'/../../config/elastic.php';

        return ClientBuilder::fromConfig($config);
    }
}