<?php

namespace App\Repository\Elasticsearch;

use Elasticsearch\Client;


class ElasticsearchSearchRepository
{
    /**
     * Коннектор для сервера Elasticsearch
     * @var Client
     */
    private Client $elasticSearch;

    public function __construct(Client $elasticSearch)
    {
        $this->elasticSearch = $elasticSearch;
    }

    /**
     * @return array
     */
    public function getInfo():array
    {
        return $this->elasticSearch->info();
    }
}