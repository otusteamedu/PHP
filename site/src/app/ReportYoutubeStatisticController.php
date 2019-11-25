<?php

namespace App;



class ReportYoutubeStatisticController implements YoutubeCount
{
  
    public function  chanelAllVideoLikeStatistics($id, YoutubeChannelStatisticsMapper $youtubeChannelStatisticsMapper)
    {
        $channel = $youtubeChannelStatisticsMapper->getById($id);
      
       return $channel->getSumLike();
    }

    public function topChanelStatistics(YoutubeChannelsStatisticsMapper $youtubeChannelsStatisticsMapper)
    {

       $channel = $youtubeChannelsStatisticsMapper->sortChannelsDifLikeDesc();
      return $channel->getDifLikes();
    }
 
}
