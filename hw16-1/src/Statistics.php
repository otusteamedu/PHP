<?php

namespace TimGa\Youtube;

use MongoDB\Collection;

class Statistics
{
    public $videoCollection;

    public function __construct(Collection $videoCollection)
    {
        $this->videoCollection = $videoCollection;
    }

    public function getLikesCountForChannel(string $channelName) : int
    {
        $cursor = $this->videoCollection->aggregate([
            ['$match' => ['channelName' => $channelName]],
            ['$group' => ['_id' => '$channelName', 'likes' => ['$sum' => '$likes']]]
        ]);

        foreach ($cursor as $channelId) {
            return $channelId['likes'];
        }
    }

    public function getDislikesCountForChannel(string $channelName) : int
    {
        $cursor = $this->videoCollection->aggregate([
            ['$match' => ['channelName' => $channelName]],
            ['$group' => ['_id' => '$channelName', 'dislikes' => ['$sum' => '$dislikes']]]
        ]);

        foreach ($cursor as $channelId) {
            return $channelId['dislikes'];
        }
    }

    public function getTopChannels() : array
    {
        $cursor = $this->videoCollection->aggregate([
            ['$group' => ['_id' => '$channelName', 'likes' => ['$sum' => '$likes'], 'dislikes' => ['$sum' => '$dislikes']]],
            ['$addFields' => ['ratio' => ['$divide' => ['$likes', '$dislikes']]]],
            ['$sort' => ['ratio' => -1]]
        ]);

        $result = [];
        foreach ($cursor as $channelData) {
            $result[] = [
                'channelName' => $channelData['_id'],
                'likesCount' => $channelData['likes'],
                'dislikesCount' => $channelData['dislikes'],
                'ratio' => $channelData['ratio'],
            ];
        }
        return $result;
    }
}
