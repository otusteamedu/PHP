<?php


namespace App\Repository;


use App\Model\Builders\ChannelBuilder;
use App\Model\YouTubeChannel;
use App\Model\YouTubeVideo;
use Elasticsearch\Client;
use Psr\Container\ContainerInterface;

class ElasticsearchChannels
{
    private Client $client;
    private ChannelBuilder $builder;
    private int $totalCount = 0;

    /**
     * ElasticsearchSearchSnippets constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->client = $container->get('elastic');
        $this->builder = new ChannelBuilder();
    }

    public function search(string $query, int $limit = 0, int $offset = 0): array
    {
        $items = $this->searchOnElastic($query, $limit, $offset);
        return $this->buildCollection($items);
    }

    private function searchOnElastic(string $query, int $limit, int $offset = 0): array
    {
        $query = $query ?? '';

        $channel = new YouTubeChannel();

        return $this->client->search([
            'index' => $channel->getSearchIndex(),
            'body' => [
                'query' => [
                    'query_string' => [
                        'fields' => [
                            'title^2',
                            'description'
                        ],
                        'query' => '*' . $query . '*',
                        'analyze_wildcard' => true,
                        'allow_leading_wildcard' => true,
                    ]
                ]
            ],
            'size' => $limit,
            'from' => $offset,
        ]);
    }

    public function findOne(string $id): YouTubeChannel
    {
        $model = new YouTubeChannel();
        $params = [
            'index' => $model->getSearchIndex(),
            'id'    => $id
        ];

        $source = $this->client->getSource($params);
        return $this->builder->buildFromElasticResult($source);
    }

    public function findAll(): array
    {
        $model = new YouTubeChannel();

        $result = $this->client->search([
            'index' => $model->getSearchIndex()
        ]);

        return $this->buildCollection($result);
    }



    private function buildCollection(array $items): array
    {
        if (!$items) {
            return [];
        }

        $this->totalCount = $items['hits']['total']['value'];

        $channels = [];
        $values = $items['hits']['hits'];
        foreach ($values as $item) {
            $channel = $this->builder->buildFromElasticResult($item['_source']);
            array_push($channels, $channel);
        }

        return $channels;
    }

}
