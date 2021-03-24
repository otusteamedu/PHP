<?php


namespace App\Services;


use App\Model\SearchInterface;
use Elasticsearch\Client;

class ElasticsearchService
{
    private Client $client;

    /**
     * ElasticsearchService constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function loadModel(SearchInterface $model)
    {
        $this->client->index([
            'index' => $model->getSearchIndex(),
            'id' => $model->getId(),
            'body' => $model->getSearchArray()
        ]);
    }
}
