<?php
namespace App;
use App\Database;
use MongoDB;

class YoutubeChannel extends Database
{

    
    private $_id;

    private $id;

    private $title;

    private $description;

    private $commentCount;

    private $publishedAt;

    private $viewCount;

    private $subscriberCount;

    private $hiddenSubscriberCount;

    private $videoCount;

    private $privacyStatus;

    private $videoId;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function getId()
    {

        return $this->id;
    }
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    public function getDescription()
    {
        return $this->descriptions;
    }
    public function setViewCount($viewCount)
    {
        $this->viewCount = $viewCount;
        return $this;
    }

    public function getCommentCount()
    {
        return $this->commentCount;
    }

    public function setCommentCount($commentCount)
    {
        $this->commentCount = $commentCount;
        return $this;
    }

    public function getViewCount()
    {
        return $this->viewCount;
    }
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;
        return $this;
    }
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }
    public function setSubscriberCount($subscriberCount)
    {
        $this->subscriberCount = $subscriberCount;
        return $this;
    }
    public function getSubscriberCount()
    {
        return $this->subscriberCount;
    }

    public function setHiddenSubscriberCount($hiddenSubscriberCount)
    {
        $this->hiddenSubscriberCount = $hiddenSubscriberCount;
        return $this;
    }
    public function getHiddenSubscriberCount()
    {

        return  $this->hiddenSubscriberCount;
    }
    public function setVideoCount($videoCount)
    {
        $this->videoCount = $videoCount;
        return $this;
    }
    public function getVideoCount()
    {
        // $this->videoCount=$videoCount;
        return $this->videoCount;
    }
    public function setPrivacyStatus($privacyStatus)
    {
        $this->privacyStatus = $privacyStatus;
        return $this;
    }

    public function getPrivacyStatus()
    {

        return $this->privacyStatus;
    }

    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;
        return $this;
    }

    public function getVideoId()
    {

        return $this->videoId;
    }



   


    public function insert()
    {
        $collectionYoutubeChannel = $this->db->youtube->channel;

        $insertOneResult = $collectionYoutubeChannel->insertOne([
            'id' => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            'publishedAt' => $this->publishedAt,
            'viewCount' => $this->viewCount,
            'commentCount' => $this->commentCount,
            'subscriberCount' => $this->subscriberCount,
            'hiddenSubscriberCount' => $this->hiddenSubscriberCount,
            'videoCount' => $this->videoCount,
            'privacyStatus' => $this->privacyStatus,
            'videoId' => $this->videoId,
        ]);
        $this->_id = $insertOneResult->getInsertedId();
        printf("Inserted %s video(s)\n", $insertOneResult->getInsertedId());
        return $insertOneResult;
    }

    public static function getById($idchanel)
    {
        $db =  new MongoDB\Client(self::protocol."://".self::dns.":".self::port);
      //  $collectionYoutubeChannel = $db->youtube->channel;
        $collectionYoutubeChannel = $db->youtube->channel;
        $findOneResult = $collectionYoutubeChannel->findOne(['id' => $idchanel]);
      // var_dump($findOneResult);
       //exit;
        return (new self($db))
            ->setId($findOneResult["id"])
            ->setTitle($findOneResult["title"])
            ->setDescription($findOneResult["description"])
            ->setPublishedAt($findOneResult["publishedA"])
            ->setViewCount($findOneResult["viewCount"])
            ->setCommentCount($findOneResult["commentCount"])
            ->setSubscriberCount($findOneResult["subscriberCount"])
            ->setHiddenSubscriberCount($findOneResult["hiddenSubscriberCount"])
            ->setVideoCount($findOneResult['videoCount'])
            ->setPrivacyStatus($findOneResult['privacyStatus'])
            ->setVideoId($findOneResult['videoId']);
    }

    public function delete()
    {

        $id = $this->id;
        $this->id = null;
        $collectionYoutubeChannel = $this->db->youtube->channel;
        return $delet = $collectionYoutubeChannel->deleteOne(['id' => $id]);
    }
}
