<?php
namespace App;
use App\Database;
use App\YoutubeVideoMapper;
use App\YoutubeChannelsStatisticsMapper;
use App\YoutubeChannelStatisticsMapper;
use App\YoutubeChannelMapper;
use App\YoutubeClassLoad;


class LazyLoad implements YoutubeClassLoad {
   // protected $class = null;
    protected $youtubeChannelMapper =null;
    protected $youtubeChannelsStatisticsMapper= null;
    protected $youtubeChannelStatisticsMapper =null;
    protected $youtubeVideoMapper=null;


    public function getYoutubeChannelMapper() {
        if ($this->youtubeChannelMapper == null) {
            $db=Database::init();
            $this->youtubeChannelMapper = new YoutubeChannelMapper($db);
        }
        return $this->youtubeChannelMapper;
    }

    public function getYoutubeChannelsStatisticsMapper() {
        if ($this->youtubeChannelsStatisticsMapper == null) {
            $db=Database::init();
            $this->youtubeChannelsStatisticsMapper = new YoutubeChannelsStatisticsMapper($db);
        }
        return $this->youtubeChannelsStatisticsMapper;
    }
    public function getYoutubeChannelStatisticsMapper() {
        if ($this->youtubeChannelStatisticsMapper == null) {
            $db=Database::init();
            $this->youtubeChannelStatisticsMapper = new YoutubeChannelStatisticsMapper($db);
        }
        return $this->youtubeChannelStatisticsMapper;
    }
    public function getYoutubeVideoMapper() {
        if ($this->youtubeVideoMapper == null) {
            $db=Database::init();
            $this->youtubeVideoMapper = new YoutubeVideoMapper($db);
        }
        return $this->youtubeVideoMapper;
    }

}