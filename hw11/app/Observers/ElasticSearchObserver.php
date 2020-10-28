<?php

namespace App\Observers;

class ElasticSearchObserver
{
    private \Elasticsearch\Client $elasticsearch;

    public function __construct(\Elasticsearch\Client $client) {
        $this->elasticsearch = $client;
    }

    public function saved($model)
    {
        $this->elasticsearch->index([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
            'body' => $model->toSearchArray(),
        ]);
    }
    public function deleted($model)
    {
        $this->elasticsearch->delete([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
        ]);
    }
}
