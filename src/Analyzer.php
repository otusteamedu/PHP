<?php

namespace hw16;

use MongoDB\Collection;

/**
 * Class Analyzer
 * @package hw16
 *
 * @property Collection $videoCollection
 */
class Analyzer
{
    public $videoCollection;

    /**
     * Analyzer constructor.
     * @param Collection $videoCollection
     */
    public function __construct(Collection $videoCollection)
    {
        $this->videoCollection = $videoCollection;
    }

    /**
     * @param string $channel
     * @return int
     */
    public function getCountChannelLikes(string $channel): int
    {
        $cursor = $this->videoCollection->aggregate([
            ['$match' => ['_id' => $channel]],
            ['$group' => ['_id' => '_id.$name', 'likes' => ['$sum' => '$likes']]]
        ]);
        foreach ($cursor as $channelId) {
            return $channelId;
        }
    }

    /**
     * @param string $channel
     * @return int
     */
    public function getCountChannelDislikes(string $channel): int
    {
        $cursor = $this->videoCollection->aggregate([
            ['$match' => ['_id' => $channel]],
            ['$group' => ['_id' => '_id.$name', 'dislikes' => ['$sum' => '$dislikes']]]
        ]);
        foreach ($cursor as $channelId) {
            return $channelId['dislikes'];
        }
    }

    /**
     * @return array
     */
    public function getTopChannels(): array
    {
        $cursor = $this->videoCollection->aggregate([
            ['$group' => ['_id' => '$name', 'likes' => ['$sum' => '$likes'], 'dislikes' => ['$sum' => '$dislikes']]],
            ['$addFields' => ['rating' => ['$divide' => ['$likes', '$dislikes']]]],
            ['$sort' => ['rating' => -1]]
        ]);
        $result = [];
        foreach ($cursor as $channelData) {
            $result[] = [
                'name' => $channelData['_id'],
                'likes' => $channelData['likes'],
                'dislikes' => $channelData['dislikes'],
                'rating' => $channelData['rating'],
            ];
        }
        return $result;
    }
}