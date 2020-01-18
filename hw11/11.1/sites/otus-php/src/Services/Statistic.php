<?php

namespace App\Services;

use MongoDB\Database;
use MongoDB\Driver\Cursor;

class Statistic
{
    /** @var Database $db */
    private $db;

    public function __construct(object $db)
    {
        $this->db = $db;
    }

    public function sumAllChannelLikes(string $channelUrl): array
    {
        $videoCol = $this->db->selectCollection('videos');
        $videos = $videoCol->find(
            ['channel_url' => $channelUrl],
            [
                'projection' => [
                    'likes' => 1,
                    'dislikes' => 1,
                ]
            ]
        );

        $result = ['likes' => 0, 'dislikes' => 0];
        foreach ($videos as $video) {
            $result['likes'] += $video->likes;
            $result['dislikes'] += $video->dislikes;
        }

        return $result;
    }

    public function topRateChannels(int $channelLimit): array
    {
        $channelsCol = $this->db->selectCollection('channels');
        /** @var Cursor $channels*/
        $channels = $channelsCol->find([]);

        $ratings = [];
        foreach ($channels->toArray() as $channel) {
            if ($channelLimit < 1) {
                return $this->sortChannelsByRate($ratings);
            }

            $sumLikes = $this->sumAllChannelLikes($channel->url);
            $ratings[$channel->url] = $this->calcChannelRate($sumLikes);

            --$channelLimit;
        }

        return $this->sortChannelsByRate($ratings);
    }

    public function calcChannelRate(array $sumLikes): float
    {
        return $sumLikes['likes'] / $sumLikes['dislikes'];
    }

    public function sortChannelsByRate(array $ratings): array
    {
        arsort($ratings);

        return $ratings;
    }
}