<?php
namespace App;
use App\YoutubeChannel;

class YoutubeChannelMapper
{


    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }


    public function insert($raw)
    {
        $collectionYoutubeChannel = $this->db->youtube->channel;

        $insertOneResult = $collectionYoutubeChannel->insertOne([
            'id' => $raw['id'],
            "title" => $raw['title'],
            "description" => $raw['description'],
            'publishedAt' => $raw['publishedAt'],
            'viewCount' => $raw['viewCount'],
            'commentCount' => $raw['commentCount'],
            'subscriberCount' => $raw['subscriberCount'],
            'hiddenSubscriberCount' => $raw['hiddenSubscriberCount'],
            'videoCount' => $raw['videoCount'],
            'privacyStatus' => $raw['privacyStatus'],
            'videoId' => $raw['videoId'],
        ]);
        $this->_id = $insertOneResult->getInsertedId();
        printf("Inserted %s video(s)\n", $insertOneResult->getInsertedId());
        return $insertOneResult;
    }

    public function getById($idchanel)
    {

        $collectionYoutubeChannel = $this->db->youtube->channel;
        $findOneResult = $collectionYoutubeChannel->findOne(['id' => $idchanel]);
        return new YoutubeChannel(
            $findOneResult["_id"],
            $idchanel,
            $findOneResult["title"],
            $findOneResult["description"],
            $findOneResult["publishedA"],
            $findOneResult["viewCount"],
            $findOneResult["commentCount"],
            $findOneResult["subscriberCount"],
            $findOneResult["hiddenSubscriberCount"],
            $findOneResult['videoCount'],
            $findOneResult['privacyStatus'],
            $findOneResult['videoId']
        );
    }

    public function delete($YoutubeChannel)
    {


        $collectionYoutubeChannel = $this->db->youtube->channel;
        return $delet = $collectionYoutubeChannel->deleteOne(['id' => $YoutubeChannel->get_Id()]);
    }
}
