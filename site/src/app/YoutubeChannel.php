<?php
namespace App;


class YoutubeChannel 
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

    public function get_Id(){
       return  $this->_id;
    }
    public function set_Id($_id){
        $this->_id=$_id;
        return $this;
     }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function getSumLike()
    {
       
        return 1;
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
        return $this->description;
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


public function __construct(
    $_id,
    $id,
    $title,
    $description,
    $publishedAt,
    $viewCount,
    $commentCount,
    $subscriberCount,
    $hiddenSubscriberCount,
    $videoCount,
    $privacyStatus,
    $videoId
    )
{
    $this->_id=$_id;
    $this->id=$id;
    $this->title=$title;
    $this->description=$description;
    $this->publishedAt=$publishedAt;
    $this->videoCount=$videoCount;
    $this->viewCount=$viewCount;
    $this->commentCount=$commentCount;
    $this->subscriberCount=$subscriberCount;
    $this->hiddenSubscriberCount=$hiddenSubscriberCount;
    $this->privacyStatus=$privacyStatus;
    $this->videoId=$videoId;
}



}
