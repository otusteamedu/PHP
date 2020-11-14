<?php


use Elasticsearch\ClientBuilder;
use src\ElasticIndex;

class App
{
    public $query;

    public function __construct()
    {
        $query = $this->query;
    }

    public function run()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        $host = $_ENV['elastic_host'];
    }

    public function add($query)
    {
        $index = new ElasticIndex();
        $index->addToIndex($query);
    }

    public function get($query)
    {
        $index = new ElasticIndex();
        $index->getFromIndex($query);
    }

    public function update($query)
    {
        $index = new ElasticIndex();
        $index->updateInIndex($query);
    }

    public function delete($query)
    {
        $index = new ElasticIndex();
        $index->deleteFromIndex($query);
    }

    public function search($query)
    {
        $index = new ElasticIndex();
        $index->search($query);
    }
}