<?php
namespace Youtubestat;


class Model
{
    private $collection;


    public function __construct()
    {
        $this->collection = (new \MongoDB\Client)->youtube->channels;
    }


    //add section
    public function addAll2Collection(Array $data)
    {
        $insertOneResult = $this->collection->insertMany($data);

        return $insertOneResult->getInsertedCount();
    }



    public function addItem2Collection(Array $data)
    {
        $insertOneResult = $this->collection->insertOne($data);

        return $insertOneResult->getInsertedCount();
    }
    //end add section


    //info section
    public function getAllData(Array $options = [])
    {
        $cursor = $this->collection->find(
            [],
            $options
        );

        return $cursor;
    }

    public function getChannelVideos($channelID = '')
    {
        if (empty($channelID)) {
            throw new \Exception('Missing or empty required parameter channel ID');
        }

        $jsonData = $this->collection->findOne(['channelId' => $channelID]);

        $result = [];
        if (!empty($jsonData)) {
            $result = json_decode($jsonData);
        }

        return $result;
    }
    //end info section


    // statistics section
    public function getChannelLikes($channelID = '')
    {
        if (empty($channelID)) {
            throw new \Exception('Missing or empty required parameter channel ID');
        }

        $videos = $this->getChannelVideos($channelID);
    }


    public function getTopLikeDislikeChannels($limit = 0)
    {

    }
    //end statistics section


    //delete section
    public function deleteOneChannel(Array $data)
    {
        if (empty($data)) {
            throw new \Exception('Required parameter $data is empty');
        }


        $res = $this->collection->deleteOne($data);
        return $res->getDeletedCount();
    }

    public function deleteManyChannels(Array $data)
    {
        if (empty($data)) {
            throw new \Exception('Required parameter $data is empty');
        }


        $res = $this->collection->deleteMany($data);
        return $res->getDeletedCount();
    }
    //end delete sections
}