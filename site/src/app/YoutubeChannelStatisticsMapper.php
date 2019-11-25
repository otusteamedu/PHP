<?php
namespace App;
use App\YoutubeChannelStatistics;
class YoutubeChannelStatisticsMapper
{

    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }



    public function insert($raw)
    {
        $collectionChannelSumLikeStatistics = $this->db->youtube->channelSumLikeStatistics;

        $insertOneResult = $collectionChannelSumLikeStatistics->insertOne([
            'id' => $raw['id'],
            "channelName" => $raw['channelName'],
            "sumLike" => $raw["sumLike"],
            'sumDislike' => $raw['sumDislike'],
            'difLike' => $raw['difLike'],
        ]);
        // $this->_id = $insertOneResult->getInsertedId();
        return $insertOneResult;
    }
    public  function getById($id)
    {

        $channelSumLikeStatistics = $this->db->youtube->channelSumLikeStatistics;
        $findOneResult = $channelSumLikeStatistics->findOne(['id' => $id]);
        return new  YoutubeChannelStatistics(
            $findOneResult["_id"],
            $id,
            $findOneResult["channelName"],
            $findOneResult["sumDislike"],
            $findOneResult["sumLike"],
            $findOneResult["difLike"]
        );
    }
}
