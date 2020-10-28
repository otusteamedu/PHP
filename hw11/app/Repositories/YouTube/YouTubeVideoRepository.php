<?php

namespace App\Repositories\YouTube;

use App\Models\YouTubeVideo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class YouTubeVideoRepository extends \App\Repositories\ElasticsearchRepository implements \App\Interfaces\YouTube\YouTubeRepositoryInterface {

    public function search(string $query = '') : Collection {
        $items = $this->searchOnElasticsearch($query);
        return $this->buildCollection($items, $this->getModel());
    }

    final protected function searchOnElasticsearch(string $query = '') : array {
        $model = new YouTubeVideo();
        $items = $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'type'  => $model->getSearchType(),
            'body'  => [
                'query' => [
                    'match' => [
                        'channel_id' => $query,
                    ],
                ],
            ],
            'size' => 1000
        ]);

        return $items;
    }

    final protected function getModel() : Model {
        return new YouTubeVideo();
    }

    public function getAll() : \Illuminate\Support\Collection {
        $model = new YouTubeVideo();
        $items = $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'type'  => $model->getSearchType(),
            '_source' => ["name", "channel_id", "video_id", "likes_count", "dislikes_count"],
            'body'  => [
                'query' => [
                    'match_all' => (object)[],
                ],
            ],
        ]);

        return collect(Arr::pluck($items['hits']['hits'], '_source'));
    }

}
