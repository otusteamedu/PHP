<?php

namespace App\Services;

use App\Models\BaseModel;
use App\Models\Channel;
use App\Repositories\CUDRepositoryInterface;
use App\ModelHydrators\ElasticHydratorInterface;
use JetBrains\PhpStorm\ArrayShape;

class StatisticsService
{
    /**
     * @var CUDRepositoryInterface
     */
    protected CUDRepositoryInterface $elasticChannelRepository;

    /**
     * @var ElasticHydratorInterface
     */
    protected ElasticHydratorInterface $channelModelHydrator;

    /**
     * StatisticsService constructor.
     *
     * @param CUDRepositoryInterface $elasticChannelRepository
     * @param ElasticHydratorInterface $channelModelHydrator
     */
    public function __construct(CUDRepositoryInterface $elasticChannelRepository, ElasticHydratorInterface $channelModelHydrator)
    {
        $this->elasticChannelRepository = $elasticChannelRepository;
        $this->channelModelHydrator = $channelModelHydrator;
    }

    /**
     * @param string $id
     *
     * @return array
     */
    #[ArrayShape(['likes' => "\mixed|null", 'dislikes' => "\mixed|null", 'likeAndDislikeRatio' => "\mixed|null"])]
    public function fetchChannelStatistics(string $id): array
    {
        $channel = $this->getChannelFromElastic($id);

        $statistics = $this->countLikeAndDislikeForChannel($channel);

        $this->saveStatistics($channel, $statistics);

        $statistics['channelId'] = $id;

        return $statistics;
    }

    /**
     * @param string $id
     *
     * @return Channel
     */
    protected function getChannelFromElastic(string $id): Channel
    {
        $channelRaw = $this->elasticChannelRepository->findById($id);

        return $this->channelModelHydrator->hydrate($channelRaw)[0];
    }

    /**
     * @param BaseModel $channel
     *
     * @return array
     */
    #[ArrayShape(['likes' => "mixed|null", 'dislikes' => "mixed|null", 'likeAndDislikeRatio' => "mixed|null"])]
    protected function countLikeAndDislikeForChannel(BaseModel $channel): array
    {
        $result = $this->elasticChannelRepository->fetchChannelStatistics($channel);

        return [
            'likes' => $result['aggregations']['statistics']['buckets']['likes'] ?? null,
            'dislikes' => $result['aggregations']['statistics']['buckets']['dislikes'] ?? null,
            'likeAndDislikeRatio' => $result['aggregations']['statistics']['buckets']['likeAndDislikeRatio'] ?? null,
        ];
    }

    /**
     * @param BaseModel $channel
     * @param array $statistics
     */
    protected function saveStatistics(BaseModel $channel, array $statistics): void
    {
        $this->elasticChannelRepository->update($channel, $statistics);
    }

    /**
     * @param int $quantity
     *
     * @return array
     */
    public function fetchBestChannelsStatistics(int $quantity): array
    {
        $channelsRaw = $this->elasticChannelRepository->fetchTopChannels($quantity);

        foreach ($channelsRaw['hits']['hits'] as $channelRaw) {
            $mediator = $this->channelModelHydrator->hydrate($channelRaw)[0];
            $channels[] = [
                'channelId' => $mediator->getId(),
                'likes' => $mediator->getLikesNumber(),
                'dislikes' => $mediator->getDislikesNumber(),
                'likesAndDislikesRatio' => $mediator->getLikesAndDislikesRatio()
            ];
        }

        return $channels ?? [];
    }
}
