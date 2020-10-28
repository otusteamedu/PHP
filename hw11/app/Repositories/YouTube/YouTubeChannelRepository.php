<?php

namespace App\Repositories\YouTube;

use App\Models\YouTubeChannel;
use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class YouTubeChannelRepository extends \App\Repositories\ElasticsearchRepository implements \App\Interfaces\YouTube\YouTubeRepositoryInterface {

    protected Client $elasticsearch;

    public function __construct(Client $elasticsearch) {
        parent::__construct($elasticsearch);
    }

    final protected function searchOnElasticsearch(string $query = '') : array {
        $model = new YouTubeChannel();
        $items = $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'type'  => $model->getSearchType(),
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'fields' => ['name'],
                        'query'  => $query,
                    ],
                ],
            ],
        ]);

        return $items;
    }

    final protected function getModel() : Model {
        return new YouTubeChannel();
    }

    public function getAll() : \Illuminate\Support\Collection {
        $model = new YouTubeChannel();
        $items = $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'type'  => $model->getSearchType(),
            '_source' => ["name", "channel_id"],
            'body'  => [
                'query' => [
                    'match_all' => (object)[],
                ],
            ],
        ]);

        return collect(Arr::pluck($items['hits']['hits'], '_source'));
    }
}
