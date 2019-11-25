<?php
namespace App;


interface YoutubeQuery{

    public function saveChannel($idChannel, YoutubeChannelMapper $youtubeChannelMapper);
    public function saveVideosChannel($idChannel, YoutubeVideoMapper  $youtubeVideoMapper);
    public function saveStatistic($idChannel, YoutubeChannelMapper $youtubeChannelMapper, YoutubeVideoMapper $youtubeVideoMapper, YoutubeChannelStatisticsMapper $youtubeChannelStatisticsMapper);
    public function deleteChannelAllVideos($idChanel, YoutubeChannelMapper  $youtubeChannelMapper, YoutubeVideoMapper $youtubeVideoMapper);
    public function deleteChannel($idChanel,  YoutubeChannelMapper   $youtubeChannelMapper);
}