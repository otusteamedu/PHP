<?php


namespace App\Services\Events\Repositories\Elastic;


use App\Services\Events\Repositories\iEventSearchRepository;
use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Support\Arr;

class ElasticEventSearchRepository implements iEventSearchRepository
{

    private $elastic;

    public function __construct(Client $client)
    {
        $this->elastic = $client;
    }

    public function getByCondition(array $conditions): ?array
    {
        try {
            $query = ['bool' => ['should' => []]];
            foreach ($conditions as $key => $value) {
                $query['bool']['should'][] = ['term' => ["conditions.$key" => $value]];
            }
            $items = $this->elastic->search([
                'index' => ElasticEventRepository::EVENT_INDEX,
                'type'  => ElasticEventRepository::EVENT_INDEX,
                'body'  => ['query' => $query]
            ]);
            return collect(Arr::pluck($items['hits']['hits'], '_source'))
                ->sortByDesc('priority')->filter(static function ($event) use ($conditions) {
                    return collect($event['conditions'])->diffAssoc($conditions)->isEmpty();
                })->first();
        } catch (Missing404Exception $e) {
            return null;
        }
    }
}
