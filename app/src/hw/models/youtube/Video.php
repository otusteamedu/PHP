<?php

namespace VideoPlatform\models\youtube;

use VideoPlatform\interfaces\DBInterface;
use VideoPlatform\models\ActiveRecord;

class Video extends ActiveRecord
{
    private $id;
    private $publishedAt;
    private $channelId;
    private $title;
    private $description;
    private $categoryId;
    private $viewCount;
    private $likeCount;
    private $dislikeCount;
    private $commentCount;

    private $tableName = 'videos';

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * @param mixed $publishedAt
     */
    public function setPublishedAt($publishedAt): void
    {
        $this->publishedAt = $publishedAt;
    }

    /**
     * @return mixed
     */
    public function getChannelId()
    {
        return $this->channelId;
    }

    /**
     * @param mixed $channelId
     */
    public function setChannelId($channelId): void
    {
        $this->channelId = $channelId;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param mixed $categoryId
     */
    public function setCategoryId($categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @return mixed
     */
    public function getViewCount()
    {
        return $this->viewCount;
    }

    /**
     * @param mixed $viewCount
     */
    public function setViewCount($viewCount): void
    {
        $this->viewCount = $viewCount;
    }

    /**
     * @return mixed
     */
    public function getLikeCount()
    {
        return $this->likeCount;
    }

    /**
     * @param mixed $likeCount
     */
    public function setLikeCount($likeCount): void
    {
        $this->likeCount = $likeCount;
    }

    /**
     * @return mixed
     */
    public function getDislikeCount()
    {
        return $this->dislikeCount;
    }

    /**
     * @param mixed $dislikeCount
     */
    public function setDislikeCount($dislikeCount): void
    {
        $this->dislikeCount = $dislikeCount;
    }

    /**
     * @return mixed
     */
    public function getCommentCount()
    {
        return $this->commentCount;
    }

    /**
     * @param mixed $commentCount
     */
    public function setCommentCount($commentCount): void
    {
        $this->commentCount = $commentCount;
    }

    /**
     * @param DBInterface $db
     */
    public function save(DBInterface $db)
    {
        $db->save($this->getProperties());
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return get_object_vars($this);
    }

    public static function findById(DBInterface $db, $id): self
    {
        $result = $db->findById((new self())->tableName, $id);

        $video = new self();
        $video->setId($result['id']);
        $video->setPublishedAt($result['publishedAt']);
        $video->setChannelId($result['channelId']);
        $video->setTitle($result['title']);
        $video->setDescription($result['description']);
        $video->setCategoryId($result['categoryId']);
        $video->setViewCount($result['viewCount']);
        $video->setLikeCount($result['likeCount']);
        $video->setDislikeCount($result['dislikeCount']);
        $video->setCommentCount($result['commentCount']);

        return $video;
    }

}