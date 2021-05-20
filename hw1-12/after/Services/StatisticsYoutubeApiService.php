<?php

class StatisticsYoutubeApiService implements StatisticsYoutubeApiServiceInterface
{
    private RepositoryInterface $repository;

    public function __construct(RepositoryInterface $repository){
        $this->repository = $repository;
    }

    /**
     * This method get statistics sum of likes and dislikes
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