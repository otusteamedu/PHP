<?php

namespace App;

use App\YoutubeContent;
use App\YoutubeChannel;
use App\YoutubeVideo;
use App\YoutubeStatistics;

class YoutubeController
{
    public $sumLike = 0;
    public $sumDisLike = 0;
    public $diffLike = 0;

    public function saveChannel($idchannel)
    {
        $youtubeContent = new YoutubeContent();
        $channelInfo = $youtubeContent->getChannelInfo($idchannel);
        $channelVideoId = $youtubeContent->getVideosChannelIds($idchannel);
        $YoutubeChannel = new YoutubeChannel();
        $YoutubeChannel->setId($channelInfo->items[0]->id);
        $YoutubeChannel->setTitle($channelInfo->items[0]->snippet->title);
        $YoutubeChannel->setDescription($channelInfo->items[0]->snippet->description);
        $YoutubeChannel->setPublishedAt($channelInfo->items[0]->snippet->publishedAt);
        $YoutubeChannel->setViewCount($channelInfo->items[0]->statistics->viewCount);
        $YoutubeChannel->setCommentCount($channelInfo->items[0]->statistics->commentCount);
        $YoutubeChannel->setSubscriberCount($channelInfo->items[0]->statistics->subscriberCount);
        $YoutubeChannel->setHiddenSubscriberCount($channelInfo->items[0]->statistics->hiddenSubscriberCount);
        $YoutubeChannel->setVideoCount($channelInfo->items[0]->statistics->videoCount);
        $YoutubeChannel->setPrivacyStatus($channelInfo->items[0]->status->privacyStatus);
        $YoutubeChannel->setVideoId($channelVideoId);
        $YoutubeChannel->insert();
    }

    public function saveVideosChannel($idchannel)
    {
        $youtubeContent = new YoutubeContent();
        $youtubeVideo = new YoutubeVideo();
        $channelVideoId = $youtubeContent->getVideosChannelIds($idchannel);

        foreach ($channelVideoId as $key => $value) {
            $channelVideo = $youtubeContent->getVideosChannelInfo($value);
            /*  var_dump($channelVideo->items[0]->statistics);
            exit;*/
            $youtubeVideo->setId($channelVideo->items[0]->id);
            $youtubeVideo->setChannelId($channelVideo->items[0]->snippet->channelId);
            $youtubeVideo->setDescription($channelVideo->items[0]->snippet->description);
            $youtubeVideo->setPublishedAt($channelVideo->items[0]->snippet->publishedAt);
            $youtubeVideo->setTitle($channelVideo->items[0]->snippet->title);
            $youtubeVideo->setCategoryId($channelVideo->items[0]->snippet->categoryId);
            $youtubeVideo->setPrivacyStatus($channelVideo->items[0]->status->privacyStatus);
            $youtubeVideo->setPublicStatsViewable($channelVideo->items[0]->status->publicStatsViewable);
            $youtubeVideo->setViewCount($channelVideo->items[0]->statistics->viewCount);
            $youtubeVideo->setlikeCount($channelVideo->items[0]->statistics->likeCount);
            $youtubeVideo->setDislikeCount($channelVideo->items[0]->statistics->dislikeCount);
            $youtubeVideo->setFavoriteCount($channelVideo->items[0]->statistics->favoriteCount);
            $youtubeVideo->setCommentCount($channelVideo->items[0]->statistics->commentCount);
            $youtubeVideo->insert();
        }
    }
    public function saveStatistic($idchannel)
    {

     
        $channel = YoutubeChannel::getById($idchannel);
        $videoId = $channel->getVideoId();
        $id = $channel->getId();
        $channelName = $channel->getTitle();
        foreach ($videoId as $key => $value) {
            $video = YoutubeVideo::getById($value);
            $this->sumLike += $video->getLikeCount();
            $this->sumDisLike += $video->getDisLikeCount();
        }
        $this->diffLike = $this->sumLike - $this->sumDisLike;
        $YoutubeStatistics = new YoutubeStatistics;
        $YoutubeStatistics->setId($id);
        $YoutubeStatistics->setChannelName($channelName);
        $YoutubeStatistics->setSumLike($this->sumLike);
        $YoutubeStatistics->setSumDisLike($this->sumDisLike);
        $YoutubeStatistics->setDifLike($this->diffLike);
        $YoutubeStatistics->insert();
    }
    public function  chanelAllVideoLikeStatistics($id)
    {
        $YoutubeStatistics = new YoutubeStatistics;
        $channel = YoutubeStatistics::getById($id);
        return $channel->getSumLike();
    }

    public function topChanelStatistics()
    {

        $channel = YoutubeStatistics::topChanelStatistics();
        return $channel->getDifLike();
    }
    public function deleteChannelAllVideos($idchanel)
    {
        $youtubeVideo = new YoutubeVideo();
        $channel = YoutubeChannel::getById($idchanel);
        $videoId = $channel->getVideoId();
        foreach ($videoId as $key => $value) {
            $youtubeVideo->setId($value);
            $youtubeVideo->delete();
        }
        $YoutubeChannel = new YoutubeChannel();
        $YoutubeChannel->setId($idchanel);
        $YoutubeChannel->delete();
    }
}
