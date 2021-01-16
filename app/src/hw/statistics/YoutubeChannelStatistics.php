<?php
namespace VideoPlatform\statistics;

use VideoPlatform\interfaces\DBInterface;
use VideoPlatform\models\youtube\Channel;
use VideoPlatform\models\youtube\Video;

class YoutubeChannelStatistics
{
    private DBInterface $db;
    private Channel $channel;

    public function __construct(DBInterface $db, Channel $channel)
    {
        $this->db = $db;
        $this->channel = $channel;
    }

    public function getTotalLikesDislikes()
    {
        $queryParams = [
            'where' => [
                'channelId' => $this->channel->getId()
            ],
            'limit' => 5,
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
}