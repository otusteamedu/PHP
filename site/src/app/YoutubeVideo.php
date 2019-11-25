<?php

namespace App;



class YoutubeVideo
{
    private $_id;
    private $id;
    private $channelId;
    private $description;
    private $publishedAt;
    private $title;
    private $categoryId;
    private $privacyStatus;
    private $publicStatsViewable;
    private $viewCount;
    private $likeCount;
    private $dislikeCount;
    private $favoriteCount;
    private $commentCount;

    public function set_Id($_id)
    {
        $this->_id = $_id;
        return $this;
    }
    public function get_Id()
    {

        return $this->_id;
    }

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
    public function __construct(
        $_id,
        $id,
        $channelId,
        $description,
        $publishedAt,
        $title,
        $categoryId,
        $privacyStatus,
        $publicStatsViewable,
        $viewCount,
        $likeCount,
        $dislikeCount,
        $favoriteCount,
        $commentCount
    ) {
        $this->_id = $_id;
        $this->id = $id;
        $this->channelId = $channelId;
        $this->description = $description;
        $this->publishedAt = $publishedAt;
        $this->title = $title;
        $this->categoryId = $categoryId;
        $this->privacyStatus = $privacyStatus;
        $this->publicStatsViewable = $publicStatsViewable;
        $this->viewCount = $viewCount;
        $this->likeCount = $likeCount;
        $this->dislikeCount = $dislikeCount;
        $this->favoriteCount = $favoriteCount;
        $this->commentCount = $commentCount;
    }
}
