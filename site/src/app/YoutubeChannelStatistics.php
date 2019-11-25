<?php

namespace App;

use App\Connect\Database;
use MongoDB;

class YoutubeChannelStatistics
{
    private $_id;
    private $id;
    private $channelName;
    private $sumLike;
    private $sumDislike;
    private $difLike;
    public function get_id()
    {
        return  $this->_id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getChannelName()
    {
        return $this->channelName;
    }

    public function setSumLike($sumLike)
    {
        $this->sumLike = $sumLike;
        return $this;
    }
    public function getSumLike()
    {

        return $this->sumLike;
    }
    public function setSumDisLike($sumDisLike)
    {
        $this->sumDislike = $sumDisLike;
        return $this;
    }
    public function getSumDisLike()
    {
        return $this->sumDislike;
    }
    public function getDifLike()
    {
        return $this->difLike;
    }
    public function setDifLike($difLike)
    {
        $this->difLike = $difLike;
        return $this;
    }
    public function setChannelName($channelName)
    {
        $this->channelName = $channelName;
        return $this;
    }
    public function __construct($_id, $id, $channelName, $sumLike, $sumDisLike, $difLike)
    {
        $this->_id = $_id;
        $this->id = $id;
        $this->channelName = $channelName;
        $this->sumLike = $sumLike;
        $this->sumDislike = $sumDisLike;
        $this->difLike = $difLike;
    }
}
