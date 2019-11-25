<?php

namespace App;

use App\YoutubeQuery;

class ReportYoutubeDataController implements YoutubeQuery
{
    public $sumLike = 0;
    public $sumDisLike = 0;
    public $diffLike = 0;

    public $youtubeContent;

    public function __construct(YoutubeContent $youtubeContent)
    {
        $this->youtubeContent = $youtubeContent;
    }

    public function saveChannel($idChannel, YoutubeChannelMapper $youtubeChannelMapper)
    {
        $channelInfo = $this->youtubeContent->getChannelInfo($idChannel);
        $channelVideoId = $this->youtubeContent->getVideosChannelIds($idChannel);
        $channelInfo['videoId'] = $channelVideoId;
        $youtubeChannelMapper->insert($channelInfo);
    }

    public function saveVideosChannel($idChannel, YoutubeVideoMapper  $youtubeVideoMapper)
    {
        $channelVideoId = $this->youtubeContent->getVideosChannelIds($idChannel);

        foreach ($channelVideoId as $key => $value) {
            $channelVideo = $this->youtubeContent->getVideosChannelInfo($value);
            $youtubeVideoMapper->insert($channelVideo);
        }
    }
    public function saveStatistic($idChannel, YoutubeChannelMapper $youtubeChannelMapper, YoutubeVideoMapper $youtubeVideoMapper, YoutubeChannelStatisticsMapper $youtubeChannelStatisticsMapper)
    {
        $channel = $youtubeChannelMapper->getById($idChannel);
        $videoId = $channel->getVideoId();
        $id = $channel->getId();
        $channelName = $channel->getTitle();
        foreach ($videoId as $key => $value) {
            $video = $youtubeVideoMapper->getById($value);
            $this->sumLike += $video->getLikeCount();
            $this->sumDisLike += $video->getDisLikeCount();
        }
        $this->diffLike = $this->sumLike - $this->sumDisLike;
        $statistic['id'] = $id;
        $statistic['channelName'] = $channelName;
        $statistic['sumLike'] = $this->sumLike;
        $statistic['sumDislike'] = $this->sumDisLike;
        $statistic['difLike'] = $this->diffLike;
        $youtubeChannelStatisticsMapper->insert($statistic);
    }
    public function deleteChannelAllVideos($idChanel, YoutubeChannelMapper  $youtubeChannelMapper, YoutubeVideoMapper $youtubeVideoMapper)
    {

        $channel = $youtubeChannelMapper->getById($idChanel);
        $videoId = $channel->getVideoId();
        foreach ($videoId as $key => $value) {
            $youtubeVideo = $youtubeVideoMapper->getById($value);
            $youtubeVideoMapper->delete($youtubeVideo);
        }
    }

    public function deleteChannel($idChanel,  YoutubeChannelMapper   $youtubeChannelMapper)
    {
        $youtubeChannelMapper->delete($youtubeChannelMapper->getById($idChanel));
    }
}
