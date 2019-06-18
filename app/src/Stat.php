<?php

namespace App;

use MongoDB\Driver\Exception\Exception;

/**
 * Class Stat
 * @package App
 */
class Stat
{
    /**
     * @var MongoRepository
     */
    private $channelRepository;

    /**
     * @var MongoRepository
     */
    private $videoRepository;

    /**
     * VideoStat constructor.
     * @param MongoRepository $channelRepository
     * @param MongoRepository $videoRepository
     */
    public function __construct(MongoRepository $channelRepository, MongoRepository $videoRepository)
    {
        $this->channelRepository = $channelRepository;
        $this->videoRepository = $videoRepository;
    }

    /**
     * @param string $channelId
     * @return int
     * @throws Exception
     */
    public function getChannelTotalLikeCount(string $channelId): int
    {
        $likeCount = 0;
        foreach ($this->videoRepository->find(['channelId' => $channelId]) as $video) {
            $likeCount += (int)$video->likeCount;
        }

        return $likeCount;
    }

    /**
     * @param string $channelId
     * @return int
     * @throws Exception
     */
    public function getChannelTotalDislikeCount(string $channelId): int
    {
        $dislikeCount = 0;
        foreach ($this->videoRepository->find(['channelId' => $channelId]) as $video) {
            $dislikeCount += (int)$video->dislikeCount;
        }

        return $dislikeCount;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getTopChannels(): array
    {
        $top = [];
        foreach ($this->channelRepository->find([]) as $channel) {
            $likes = (int)$this->getChannelTotalLikeCount($channel->_id);
            $dislikes = (int)$this->getChannelTotalDislikeCount($channel->_id);
            $top[] = [
                'title' => $channel->title,
                'rate' => $likes / $dislikes,
            ];
        }

        usort($top, [$this, 'myCmp']);

        return $top;
    }

    /**
     * @param $a
     * @param $b
     * @return int|\lt
     */
    private function myCmp($a, $b)
    {
        return strcmp($b['rate'], $a['rate']);
    }
}