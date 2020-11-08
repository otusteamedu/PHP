<?php

use CreateElasticClient;

class App
{
    public function run()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        $host = $_ENV['elastic_host'];

        $client = new CreateElasticClient($host);
    }
}