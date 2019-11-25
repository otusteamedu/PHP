<?php

namespace App;

interface  YoutubeCount{

    public function  chanelAllVideoLikeStatistics($id, YoutubeChannelStatisticsMapper $youtubeChannelStatisticsMapper);
    public function topChanelStatistics(YoutubeChannelsStatisticsMapper $youtubeChannelsStatisticsMapper);
}
