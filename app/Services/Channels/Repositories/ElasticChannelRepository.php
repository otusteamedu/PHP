<?php


namespace App\Services\Channels\Repositories;


use App\Models\Channel;
use Elasticsearch\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ElasticChannelRepository implements ChannelRepositoryInterface
{

    /**@var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function search(string $query = ''): Collection
    {
        return $this->buildCollection($this->searchByElastic($query));
    }

    private function searchByElastic(string $query = ''): array
    {
        $channel = new Channel;
        return $this->client->search([
            'index' => $channel->getSearchIndex(),
            'type'  => $channel->getSearchType(),
            'body'  => [
                'query' => [
                    'query_string' => [
                        'fields'                 => [
                            'name^5',
                            'description',
                            'tags',
                        ],
                        'query'                  => '*' . $query . '*',
                        "analyze_wildcard"       => true,
                        "allow_leading_wildcard" => true
                    ]
                ]
            ]
        ]);
    }

    private function buildCollection(array $items): Collection
    {
        return Collection::make(Arr::pluck($items['hits']['hits'], '_source'));
    }
}
