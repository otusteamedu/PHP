<?php


namespace App\Services\Channels\Repositories;


use App\Models\Channel;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class ElasticSearchChannelRepository implements Interfaces\SearchChannelRepositoryInterface
{
    private Client $elasticsearch;

    public function __construct()
    {
        $this->elasticsearch = ClientBuilder::create()->build();
    }

    public function search(string $q): ?Channel
    {
        $res = $this->searchOnElasticsearchByChannelId($q);
        return $this->aggregateSearchedData($res);
    }

    public function getTop(): array
    {
        $channels = $this->getAllChannels();
        return $this->aggregateTopData($channels);
    }

    private function getAllChannels()
    {
        $model = new Channel();
        return $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
        ]);
    }

    private function searchOnElasticsearchByChannelId(string $query): array
    {
        $model = new Channel();
        return $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                'query' => [
                    'query_string' => [
                        'fields' => $model->toSearchArray(),
                        'query' => $query . '*',
                        "analyze_wildcard" => true,
                        "allow_leading_wildcard" => true
                    ],
                ],
            ],
        ]);
    }

    private function aggregateTopData(?array $channels): ?array
    {
        if (!empty($channels)) {
            $channels = $channels["hits"]["hits"];
            $rated_array = [];
            foreach ($channels as $channel) {
                $rating = $this->getChannelRating($channel);
                $rated_array[$rating] = [
                    'name' => $channel["_source"]["name"],
                    'rating' => $rating
                ];
            }
            krsort($rated_array);
            return array_slice($rated_array, 0, env('TOP_CHANNEL_COUNT'));
        }
        return null;
    }

    private function getChannelRating(array $channel): float
    {
        $likes = $channel["_source"]["likes"];
        $dislikes = $channel["_source"]["dislikes"];
        $views = $channel["_source"]["views"];
        return round(($likes / $views) / ($dislikes / $views), 1);
    }

    private function aggregateSearchedData(array $data)
    {
        if (!empty($data['hits']['hits'][0]["_source"]['channel_id'])) {
            return Channel::where('channel_id', 'LIKE', '%' . $data['hits']['hits'][0]["_source"]['channel_id'] . '%')
                ->first();
        }
        return null;
    }
}
