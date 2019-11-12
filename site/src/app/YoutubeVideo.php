<?php
namespace App;
use App\Database;
use MongoDB;

class YoutubeVideo extends Database
{   private $_id;
    private $id;
    private $channelId;
    private $description;
    private $publishedAt;
    private $title;
    private $categoryId;
    private $privacyStatus;
    private $publicStatsViewable;
    private $viewCount;
    private $dislikeCount;
    private $favoriteCount;
    private $commentCount;
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
    public function setChannelId($channelId)
    {
        $this->channelId = $channelId;
        return $this;
    }
    public function getChannelId()
    {
        return $this->channelId;
    }
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    public function getDescription()
    {
        return $this->description;
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
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
        return $this;
    }
    public function getCategoryId()
    {
        return $this->categoryId;
    }
    public  function setPrivacyStatus($privacyStatus)
    {
        $this->privacyStatus = $privacyStatus;
        return $this;
    }
    public function getPrivacyStatus()
    {
        return $this->privacyStatus;
    }
    public function setPublicStatsViewable($publicStatsViewable)
    {
        $this->publicStatsViewable = $publicStatsViewable;
        return $this;
    }
    public function getPublicStatsViewable()
    {
        return  $this->publicStatsViewable;
    }
    public function setViewCount($viewCount)
    {
        $this->viewCount = $viewCount;
        return $this;
    }
    public function getViewCount()
    {
        return $this->viewCount;
    }

    public function setLikeCount($likeCount)
    {
        $this->likeCount = $likeCount;
        return $this;
    }
    public function getLikeCount()
    {
        return  $this->likeCount;
    }
    public function setDisLikeCount($dislikeCount)
    {
        $this->dislikeCount = $dislikeCount;
        return $this;
    }
    public function getDisLikeCount()
    {

        return $this->dislikeCount;
    }

    public function setFavoriteCount($favoriteCount)
    {
        $this->favoriteCount = $favoriteCount;
        return $this;
    }
    public function getFavoriteCount()
    {
        return  $this->favoriteCount;;
    }
    public function setCommentCount($commentCount)
    {
        $this->commentCount = $commentCount;
        return $this;
    }

    public function getCommentCount()
    {
        return $this->commentCount;
    }


    public function insert()
    {
        $collectionYoutubeVideo = $this->db->youtube->video;

        $insertOneResult = $collectionYoutubeVideo->insertOne([
            'id' => $this->id,
            'channelId' => $this->channelId,
            'description' => $this->description,
            'publishedAt' => $this->publishedAt,
            'title' => $this->title,
            'categoryId' => $this->categoryId,
            'privacyStatus' => $this->privacyStatus,
            'publicStatsViewable' => $this->publicStatsViewable,
            'viewCount' => $this->viewCount,
            'likeCount' => $this->likeCount,
            'dislikeCount' => $this->dislikeCount,
            'favoriteCount' => $this->favoriteCount,
            'commentCount' => $this->commentCount,
        ]);
        $this->_id = $insertOneResult->getInsertedId();
        return $insertOneResult;
    }
    /*

*/

    public static function getById($id)
    {
        $db = new MongoDB\Client(self::protocol."://".self::dns.":".self::port);;
        $collectionYoutubeVideo = $db->youtube->video;
        $findOneResult = $collectionYoutubeVideo->findOne(['id' => $id]);
        return (new self($db))
            ->setId($findOneResult["id"])
            ->setChannelId($findOneResult["channelId"])
            ->setDescription($findOneResult["description"])
            ->setPublishedAt($findOneResult["publishedAt"])
            ->setTitle($findOneResult["title"])
            ->setCategoryId($findOneResult["categoryId"])
            ->setPrivacyStatus($findOneResult['privacyStatus'])
            ->setPublicStatsViewable($findOneResult["publicStatsViewable"])
            ->setViewCount($findOneResult['viewCount'])
            ->setLikeCount($findOneResult['likeCount'])
            ->setDislikeCount($findOneResult['dislikeCount'])
            ->setFavoriteCount($findOneResult['favoriteCount'])
            ->setCommentCount($findOneResult['commentCount']);
           // ->videoId($findOneResult['commentCount']);
        // $this->db = new MongoDB\Client("mongodb://mongo:27017");
    }
    public function delete()
    {

        $id = $this->id;
        $this->id = null;
        $collectionYoutubeVideo = $this->db->youtube->video;
        return $delet = $collectionYoutubeVideo->deleteOne(['id' => $id]);
    }
}
