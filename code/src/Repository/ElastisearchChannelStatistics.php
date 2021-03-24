<?php


namespace App\Repository;


use App\Model\Builders\ChannelBuilder;
use App\Model\Builders\StatisticBuilder;
use App\Model\ChannelStatistic;
use App\Model\YouTubeChannel;
use App\Model\YouTubeVideo;
use Elasticsearch\Client;
use Psr\Container\ContainerInterface;

class ElastisearchChannelStatistics
{
    private Client $client;
    private StatisticBuilder $builder;
    private ElasticsearchChannels $searchChannels;

    /**
     * ElasticsearchSearchSnippets constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->client = $container->get('elastic');
        $this->builder = new StatisticBuilder();
        $this->searchChannels = new ElasticsearchChannels($container);
    }

    public function getStatistics(string $channelId): ChannelStatistic
    {
        $model = new YouTubeVideo();

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

        return $this->builder->buildFromElasticResult($result);
    }

    public function topChannels(int $count = 3): array
    {
        $channels = $this->searchChannels->findAll();

        foreach ($channels as $channel) {
            $stat = $this->getStatistics($channel->getId());
            $dislikes = $stat->getDislikesCount() ? $stat->getDislikesCount() : 1;
            $ratio = $stat->getLikesCount() / $dislikes;
            $channel->setRatio($ratio);
        }

        usort($channels, fn($a, $b) => ($a->getRatio() < $b->getRatio()) ? 1 : -1);

        return array_slice($channels, 0, $count);
    }


}

