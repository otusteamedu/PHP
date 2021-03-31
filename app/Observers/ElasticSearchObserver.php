<?php


namespace App\Observers;


use Elasticsearch\Client;

class ElasticSearchObserver
{
    /** @var \Elasticsearch\Client */
    private $client;
    public function __construct(Client $elasticsearch)
    {
        $this->client = $elasticsearch;
    }
    public function saved($model)
    {
        $this->client->index([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
            'body' => $model->toSearchArray(),
        ]);
    }
    public function deleted($model)
    {
        $this->client->delete([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
        ]);
    }
}
