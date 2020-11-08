<?php

use Elasticsearch\ClientBuilder;

class CreateElasticClient
{
    public string $host;

    public function __construct(string $host)
    {
        $this->host = $host;
    }

    public function createElasticClient(string $host)
    {
        $client = ClientBuilder::create()
            ->setHosts($host)
            ->build();
    }

}