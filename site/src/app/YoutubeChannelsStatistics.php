<?php
namespace App;

use App\Connect\Database;
use MongoDB;

class YoutubeChannelsStatistics 
{
    private $_ids;
    private $ids;
    private $channelsNames;
    private $sumLikes;
    private $sumDislikes;
    private $difLikes;
    public function get_ids()
    {
        return  $this->_ids;
    }

    public function setIds($ids)
    {
        $this->ids = $ids;
        return $this;
    }

    public function getChannelsNames()
    {
        return $this->channelsNames;
    }

    public function setSumLikes($sumLikes)
    {
        $this->sumLikes = $sumLikes;
        return $this;
    }
    public function getSumLikes()
    {

        return $this->sumLikes;
    }
    public function setSumDisLikes($sumDisLike)
    {
        $this->sumDislike = $sumDisLike;
        return $this;
    }
    public function getSumDisLikes()
    {
        return $this->sumDislikes;
    }
    public function getDifLikes()
    {
        return $this->difLikes;
    }
    public function setDifLikes($difLikes)
    {
        $this->difLikes = $difLikes;
        return $this;
    }
    public function setChannelsNames($channelsNames)
    {
        $this->channelsNames = $channelsNames;
        return $this;
    }
    public function __construct($_ids, $ids, $channelsNames, $sumLikes, $sumDisLikes, $difLikes)
    {
        $this->_ids = $_ids;
        $this->ids = $ids;
        $this->channelsNames = $channelsNames;
        $this->sumLikes = $sumLikes;
        $this->sumDislikes = $sumDisLikes;
        $this->difLikes = $difLikes;
    }
}
