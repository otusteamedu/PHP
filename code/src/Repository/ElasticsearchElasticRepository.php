<?php


namespace App\Repository;


use App\Model\Builders\StatisticBuilder;
use App\Model\ChannelStatistic;
use App\Model\Interfaces\ModelElasticsearchInterface;
use App\Model\Interfaces\ModelYoutubeInterface;
use App\Model\YoutubeVideo;
use App\Repository\Exceptions\ElasticsearchNotFoundException;
use App\Repository\Interfaces\ElasticRepositoryInterface;
use Elasticsearch\Client;
use Psr\Container\ContainerInterface;

class ElasticsearchElasticRepository implements ElasticRepositoryInterface
{
    protected Client $client;

    /**
     * ElasticsearchSearchSnippets constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->client = $container->get('elastic');
    }

    /**
     * @param string $id
     * @param ModelElasticsearchInterface $model
     * @return ModelElasticsearchInterface
     */
    public function findOne(string $id, ModelElasticsearchInterface $model): ModelElasticsearchInterface
    {
        $params = [
            'index' => $model->getSearchIndex(),
            'id'    => $id
        ];
        $source = $this->client->getSource($params);
        return $model->getBuilder()->buildFromElasticResult($source);
    }

    /**
     * @param ModelElasticsearchInterface $model
     * @return ModelYoutubeInterface[]
     */
    public function findAll(ModelElasticsearchInterface $model): array
    {
        $result = $this->client->search([
            'index' => $model->getSearchIndex()
        ]);

        return $this->buildCollection($result, $model);
    }

    /**
     * @param string $channelId
     * @return ModelElasticsearchInterface[]
     * @throws ElasticsearchNotFoundException
     */
    public function findVideoByChannelId(string $channelId): array
    {
        $model = new YoutubeVideo();

        $result = $this->client->search([
            'index' => $model->getSearchIndex(),
            'body' => [
                'query' => [
                    'match' => [
                        'channelId' => $channelId,
                    ]
                ]
            ]
        ]);

        return $this->buildCollection($result, $model);

    }

    /**
     * @param string $channelId
     * @return ChannelStatistic
     */
    public function getStatistics(string $channelId): ChannelStatistic
    {
        $model = new YoutubeVideo();

        $result = $this->client->search([
            'index' => $model->getSearchIndex(),
            'body' => [
                'query' => [
                    'match' => [
                        'channelId' => $channelId,
                    ]
                ],
                'aggs' => [
                    'likesCount' => ['sum' => ['field' => 'likeCount']],
                    'dislikesCount' => ['sum' => ['field' => 'dislikeCount']]
                ]
            ],
        ]);

        return  (new StatisticBuilder())->buildFromElasticResult($result);
    }

    /**
     * @param array $items
     * @param ModelElasticsearchInterface $model
     * @return ModelElasticsearchInterface[]
     * @throws ElasticsearchNotFoundException
     */
    private function buildCollection(array $items, ModelElasticsearchInterface $model): array
    {
        if (!$items) {
            throw new ElasticsearchNotFoundException('Не удалось загрузить данные');
        }

        $models = [];
        $values = $items['hits']['hits'];
        foreach ($values as $item) {
            $item = $model->getBuilder()->buildFromElasticResult($item['_source']);
            array_push($models, $item);
        }

        return $models;
    }
}
