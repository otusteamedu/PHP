<?php

namespace App;

use App\Database;

class Statistics  extends Database
{
    public $like = 0;
    public $dislike = 0;
    public $diffLike = 0;

    public function saveStatistic($id)
    {

        $collectionYoutubeChannel = $this->db->youtube->channel;
        $сhannelVideo = $collectionYoutubeChannel->findOne(['id' => $id]);
        $collectionYoutubeVideo = $this->db->youtube->video;
        foreach ($сhannelVideo['videoId'] as $videoId) {
            $video = $collectionYoutubeVideo->findOne(['id' => $videoId]);
            $this->like += $video["likeCount"];
            $this->dislike += $video["dislikeCount"];
        }
        $this->diffLike = $this->like - $this->dislike;
        $channelSumLikeStatistics = $this->db->youtube->channelSumLikeStatistics;
        $insertOneResult1 = $channelSumLikeStatistics->insertOne([
            'id' => $сhannelVideo['id'],
            'channelName' => $сhannelVideo['title'],
            'sumLike' => $this->like,
            'sumDislike' => $this->dislike,
            'difLike' => $this->diffLike,

        ]);
    }
    public function chanelAllVideoLikeStatistics($id)
    {
        $this->saveStatistic($id);
        return $this->like;
    }

    public function topChanelStatistics()
    {

        $channelSumLikeStatistics = $this->db->youtube->channelSumLikeStatistics;
        $difLike = $channelSumLikeStatistics->find([], ['sort' => ['difLike' => -1]]);

        foreach ($difLike as $document) {
            echo $document['difLike'] . "<br>";
        }
    }
}
