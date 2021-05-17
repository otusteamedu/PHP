<?php

class StatisticsYoutubeApiService implements StatisticsYoutubeApiServiceInterface
{
    private RepositoryInterface $repository;

    public function __construct(RepositoryInterface $repository){
        $this->repository = $repository;
    }

    /**
     * @param $channelId
     *
     * @return array
     */
    public function getStats($channelId): array
    {
        $calculateStats = $this->repository->getCalculatedStatistics($channelId);

        $calculateStats['sumOfLikesAndDislikes'] = $calculateStats['likeSum'] + $calculateStats['dislikeSum'];

        return $calculateStats;
    }
}