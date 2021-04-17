<?php
namespace Src\Services;

use Src\Repositories\ElasticSearchRepository;

/**
 * Class StatisticsService
 *
 * @package Src\Services
 */
class StatisticsService
{
    /**
     * @param $channelId
     *
     * @return array
     */
    public function getStats($channelId): array
    {
        $calculateStats = (new ElasticSearchRepository())->getCalculatedStatistics($channelId);

        $calculateStats['sumOfLikesAndDislikes'] = $calculateStats['likeSum'] + $calculateStats['dislikeSum'];

        return $calculateStats;
    }
}