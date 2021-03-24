<?php


namespace App\Repository;


use App\Model\Builders\VideoBuilder;
use App\Model\YouTubeVideo;
use Elasticsearch\Client;
use Psr\Container\ContainerInterface;

class ElasticsearchVideos
{
    private Client $client;

    public function __construct(ContainerInterface $container)
    {
        $this->client = $container->get('elastic');
    }

    public function search(string $query): array
    {
        $items = $this->searchOnElastic($query);
        return $this->buildCollection($items);
    }


    public function searchByChannel(string $channelId): array
    {
        $model = new YouTubeVideo();

        $result = $this->client->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                'query' => [
                    'query_string' => [
                        'fields' => [
                            'channelId',
                        ],
                        'query' => $channelId,
                        'analyze_wildcard' => true,
                        'allow_leading_wildcard' => true,
                    ]
                ]
            ]
        ]);

        return $this->buildCollection($result);
    }

    private function searchOnElastic(string $query): array
    {
        $query = $query ?? '';

        $model = new YouTubeVideo();

        return $this->client->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                'query' => [
                    'query_string' => [
                        'fields' => [
                            'title^2',
                            'description',
                            'tags^2'
                        ],
                        'query' => $query . '*',
                        'analyze_wildcard' => true,
                        'allow_leading_wildcard' => true,
                    ]
                ]
            ]
        ]);
    }

    private function buildCollection(array $items): array
    {
        if (!$items) {
            return [];
        }
        $values = $items['hits']['hits'];

        $builder = new VideoBuilder();

        $models = [];

        foreach ($values as $item) {
            $sn = $builder->buildFromElasticResult($item['_source']);
            array_push($models, $sn);
        }

        return $models;
    }
}


