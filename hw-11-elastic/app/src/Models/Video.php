<?php

namespace Models;

class Video extends Model
{
    public const TABLE_NAME = 'videos';

    public string $id;
    public string $title;
    public string $channelId;
    public int    $viewCount;
    public int    $likeCount;
    public int    $dislikeCount;
    public int    $commentCount;
    public string $tableName;

    public function __construct(
        string $id,
        string $title,
        string $channelId,
        int    $viewCount,
        int    $likeCount,
        int    $dislikeCount,
        int    $commentCount
    ) {
        $this->id           = $id;
        $this->title        = $title;
        $this->channelId    = $channelId;
        $this->viewCount    = $viewCount;
        $this->likeCount    = $likeCount;
        $this->dislikeCount = $dislikeCount;
        $this->commentCount = $commentCount;
        $this->tableName    = Video::TABLE_NAME;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getChannelId(): string
    {
        return $this->channelId;
    }

    public function setChannelId(string $channelId): self
    {
        $this->channelId = $channelId;
        return $this;
    }

    public function getViewCount(): int
    {
        return $this->viewCount;
    }

    public function setViewCount(int $viewCount): self
    {
        $this->viewCount = $viewCount;
        return $this;
    }

    public function getLikeCount(): int
    {
        return $this->likeCount;
    }

    public function setLikeCount(int $likeCount): self
    {
        $this->likeCount = $likeCount;
        return $this;
    }

    public function getDislikeCount(): int
    {
        return $this->dislikeCount;
    }

    public function setDislikeCount(int $dislikeCount): self
    {
        $this->dislikeCount = $dislikeCount;
        return $this;
    }

    public function getCommentCount(): int
    {
        return $this->commentCount;
    }

    public function setCommentCount(int $commentCount): self
    {
        $this->commentCount = $commentCount;
        return $this;
    }
}
