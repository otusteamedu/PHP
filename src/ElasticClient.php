<?php


namespace src;


use \Dotenv\Dotenv;
use Elasticsearch\ClientBuilder;

class ElasticClient
{
    public function createClient()
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        $host = $_ENV['elastic_host'];
        return ClientBuilder::create()->setHosts($host)->build();
    }

}