<?php
namespace App;
use App\YoutubeChannelsStatistics;

class YoutubeChannelsStatisticsMapper{

    private $db;
    public function __construct($db)
    {
        $this->db=$db;
    }



    public function sortChannelsDifLikeDesc()
    {
        $channelSumLikeStatistics = $this->db->youtube->channelSumLikeStatistics;
        $sortChannels = $channelSumLikeStatistics->find([], ['sort' => ['difLike' => -1]]);
        foreach ($sortChannels as $channel) {
            $_ids[]= $channel['_id'];
            $ids[]= $channel['id'];
            $channelsNames[]=$channel['channelName'];
            $sumLikes[]=(int)$channel['sumLike'];
            $sumDislikes[]=(int)$channel['sumDislike'];
            $difLikes[]=(int)$channel['difLike'];
        }
        return new YoutubeChannelsStatistics(
            $_ids,
            $ids,
            $channelsNames,
            $sumLikes,
            $sumDislikes,
            $difLikes
        );
    }


}