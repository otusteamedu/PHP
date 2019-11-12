<?php
namespace App;
use App\Database;
use MongoDB;

class YoutubeStatistics extends Database
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
    public function getId()
    {
        return  $this->id;
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

    public function insert()
    {
        $collectionChannelSumLikeStatistics = $this->db->youtube->channelSumLikeStatistics;

        $insertOneResult = $collectionChannelSumLikeStatistics->insertOne([
            'id' => $this->id,
            "channelName" => $this->channelName,
            "sumLike" => $this->sumLike,
            'sumDislike' => $this->sumDislike,
            'difLike' => $this->difLike,
        ]);
        $this->_id = $insertOneResult->getInsertedId();
        return $insertOneResult;
    }
    public static function getById($id)
    {
        $db =  new MongoDB\Client(self::protocol."://".self::dns.":".self::port);
        $channelSumLikeStatistics = $db->youtube->channelSumLikeStatistics;
        $findOneResult = $channelSumLikeStatistics ->findOne(['id' => $id]);
        return (new self($db))
            ->setId($findOneResult["id"])
            ->setChannelName($findOneResult["channelName"])
            ->setSumDisLike($findOneResult["sumDislike"])
            ->setSumLike($findOneResult["sumLike"])
            ->setDifLike($findOneResult["difLike"]);
    }
    public static function topChanelStatistics(){
        $db =  new MongoDB\Client(self::protocol."://".self::dns.":".self::port);;
        $channelSumLikeStatistics = $db->youtube->channelSumLikeStatistics;
        $difLike = $channelSumLikeStatistics->find([], ['sort' => ['difLike' => -1]]);
        foreach ($difLike as $document) {
            $array[]= $document['difLike'];
        }
        return (new self($db ))
        ->setDifLike($array);
    }
}
