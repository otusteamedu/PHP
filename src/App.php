<?php


use Elasticsearch\ClientBuilder;

class App
{
    public function run()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        $host = $_ENV['elastic_host'];
    }

    public function createClient()
    {
        return ClientBuilder::create()->setHosts($host)->build();
    }
}