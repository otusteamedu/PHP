<?php

declare(strict_types=1);

namespace app\Channel;

use app\Channel;
use app\Stats;

class StatsCalculator
{
    /**
     * @var Channel
     */
    private $channel;

    public function __construct(Channel $channel)
    {
        $this->channel = $channel;
    }

    public function calculate(): Stats
    {
        $stats = new Stats();
        foreach ($this->channel->getVideoCollection()->getVideos() as $video) {
            $stats->likes += $video->getStats()->likes;
            $stats->dislikes += $video->getStats()->dislikes;
            $stats->views += $video->getStats()->views;
            $stats->commentsCount += $video->getStats()->commentsCount;
        }

        return $stats;
    }
}
