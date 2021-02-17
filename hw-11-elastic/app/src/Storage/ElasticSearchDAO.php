<?php

namespace Storage;

use Config\Config;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class ElasticSearchDAO
{
    public const STORAGE_NAME = 'elasticsearch';

    private Client $client;

    public function __construct()
    {
        $dbHost = Config::getInstance()->getItem(Storage::DB_HOST_CONFIG_KEY);

        $clientBuilder = ClientBuilder::create();
        $clientBuilder->setHosts([$dbHost]);
        $this->client = $clientBuilder->build();
    }
}