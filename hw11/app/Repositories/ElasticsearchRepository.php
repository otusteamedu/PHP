<?php

namespace App\Repositories;

use App\Models\YouTubeChannel;
use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

abstract class ElasticsearchRepository implements \App\Interfaces\SearchableInterface {

    protected Client $elasticsearch;

    public function __construct(Client $elasticsearch) {
        $this->elasticsearch = $elasticsearch;
    }

    public function search(string $query = '') : Collection {
        $items = $this->searchOnElasticsearch($query);
        return $this->buildCollection($items, $this->getModel());
    }

    abstract protected function getModel() : Model;

    abstract protected function searchOnElasticsearch(string $query = '') : array;

    protected function buildCollection(array $items, Model $model) : Collection {

        $ids = Arr::pluck($items['hits']['hits'], '_id');

        return $model::findMany($ids)
            ->sortBy(function ($item) use ($ids) {
                return array_search($item->getKey(), $ids);
            });
    }
}
