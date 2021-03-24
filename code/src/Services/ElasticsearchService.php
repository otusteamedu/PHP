<?php


namespace App\Services;


use App\Model\Interfaces\ModelElasticsearchInterface;
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

    public function loadModel(ModelElasticsearchInterface $model)
    {
        $this->client->index([
            'index' => $model->getSearchIndex(),
            'id' => $model->getId(),
            'body' => $model->getSearchArray()
        ]);
    }
}
