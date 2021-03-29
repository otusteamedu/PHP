<?php


namespace App\Services;


use App\Model\YoutubeChannel;
use App\Repository\ElasticsearchElasticRepository;
use Psr\Container\ContainerInterface;

class ChannelStatisticsService
{
    private ElasticsearchElasticRepository $repository;

    /**
     * ElasticsearchSearchSnippets constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->repository = new ElasticsearchElasticRepository($container);
    }

    /**
     * Топ каналов (likesCount / dislikesCount)
     * @param int $count
     * @return YoutubeChannel[]
     */
    public function topChannels(int $count = 3): array
    {
        $model = new YoutubeChannel();
        $channels = $this->repository->findAll($model);

        foreach ($channels as $channel) {
            $stat = $this->repository->getStatistics($channel->getId());
            $dislikes = $stat->getDislikesCount() ? $stat->getDislikesCount() : 1;
            $ratio = $stat->getLikesCount() / $dislikes;
            $channel->setRatio($ratio);
        }

        usort($channels, fn($a, $b) => ($a->getRatio() < $b->getRatio()) ? 1 : -1);

        return array_slice($channels, 0, $count);
    }

}
