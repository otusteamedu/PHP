<?php

namespace Otus;

use Exception;

/**
 * Class Informer
 * @package Otus
 */
class Informer
{
    /**
     * Get top or bottom N Documents from 'channels' by 'rates, likes, dislikes, views, subscribers or videos'
     * @param int $count
     * @param string $byValue
     * @param bool $descOrder
     * @return array
     * @throws Exception
     */
    public static function getTopChannelsByValue(int $count = 3, string $byValue = 'rates', bool $descOrder = true) : array
    {
        //TODO: maybe sort values must be const
        if (!in_array($byValue, ['rates', 'likes', 'dislikes', 'views', 'subscribers', 'videos'])) {
            throw new Exception('Sort value not in rates, likes, dislikes, views, subscribers, videos');
        }
        $channels = Channel::aggregate(
            [
                ['$lookup' => [
                    'from' => "video",
                    'localField' => "_id",
                    'foreignField' => "channelId",
                    'as' => "videos"
                ]
                ],
                ['$addFields' => [
                    'likes' => ['$sum' => '$videos.statistics.likeCount'],
                    'dislikes' => ['$sum' => '$videos.statistics.dislikeCount'],
                    'views' => '$statistics.viewCount',
                    'subscribers' => '$statistics.subscriberCount',
                    'videos' => '$statistics.videoCount',
                ]
                ],
                ['$addFields' => [
                    'rates' => ['$divide' => ['$likes', '$dislikes']],
                ]
                ],
                ['$sort' => [
                    $byValue => $descOrder ? -1 : 1
                ]
                ],
                [
                    '$limit' => $count
                ]
            ]);
        return $channels;
    }
}