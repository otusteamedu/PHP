<?php


namespace App\Observers;

use App\Models\Channel;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class ChannelObserver
{
    private Client $elasticsearch;

    public function __construct()
    {
        $this->elasticsearch = ClientBuilder::create()->build();
    }

    public function created(Channel $model)
    {
        $this->elasticsearch->indices()->create(array_merge(
            $this->generateElasticSearchParams($model), [
                'body' => $model->toSearchArray(),
            ])
        );
    }

    public function deleted(Channel $model)
    {
        $this->elasticsearch->delete(
            $this->generateElasticSearchParams($model)
        );
    }

    private function generateElasticSearchParams(Channel $model): array
    {
        return [
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
        ];
    }
}
