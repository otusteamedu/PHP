<?php
namespace VideoPlatform\statistics;

use VideoPlatform\interfaces\DBInterface;
use VideoPlatform\models\youtube\Channel;
use VideoPlatform\models\youtube\Video;

class YoutubeChannelStatistics
{
    private DBInterface $db;

    public function __construct(DBInterface $db)
    {
        $this->db = $db;
    }

    public function getTotalLikesDislikes($channelId)
    {
        $queryParams = [
            'where' => [
                'channelId' => $channelId
            ],
            'limit' => 200,
            'offset' => 0
        ];

        $response = $this->db->query((new Video())->getTableName(), $queryParams);

        $totalLikes = 0;
        $totalDislikes = 0;

        while (isset($response['hits']['hits']) && count($response['hits']['hits']) > 0) {

            foreach ($response['hits']['hits'] as $hit) {
                $totalLikes = $totalLikes + $hit['_source']['likeCount'];
                $totalDislikes = $totalDislikes + $hit['_source']['dislikeCount'];
            }

            $queryParams['offset'] = $queryParams['limit'] + $queryParams['offset'];
            $response = $this->db->query((new Video())->getTableName(), $queryParams);
        }

        return ['totalLikes' => $totalLikes, 'totalDislikes' => $totalDislikes];
    }

    public function getTopChannels(int $topN)
    {
        $channels = Channel::getAll($this->db);

        $result = [];

        foreach ($channels as $channel) {
            $total= $this->getTotalLikesDislikes($channel['_id']);
            $value = $total['totalLikes']/$total['totalDislikes'];
            $result[] =  [
                "channel_id" => $channel['_id'],
                "value" => $value
            ];
        }

        usort($result, function($a, $b) {
            return $b['value'] <=> $a['value'];
        });

        return array_slice($result, 0, $topN);
    }
}