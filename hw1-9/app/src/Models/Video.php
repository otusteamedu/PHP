<?php

namespace Src\Models;

/**
 * Class Video
 *
 * @package Src\Models
 */
class Video
{
    public const TABLE_NAME = 'video';

    public string $id;

    public string $title;

    public string $channelId;

    public int $viewsCount;

    public int $likesCount;

    public int $dislikesCount;

    public int $commentsCount;

    public function __construct(
        string $id,
        string $title,
        string $channelId,
        int $viewsCount,
        int $likesCount,
        int $dislikesCount,
        int $commentsCount
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->channelId = $channelId;
        $this->viewsCount = $viewsCount;
        $this->likesCount = $likesCount;
        $this->dislikesCount = $dislikesCount;
        $this->commentsCount = $commentsCount;
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

    public function getViewsCount(): int
    {
        return $this->viewsCount;
    }

    public function setViewsCount(int $viewsCount): self
    {
        $this->viewsCount = $viewsCount;
        return $this;
    }

    public function getLikesCount(): int
    {
        return $this->likesCount;
    }

    public function setLikesCount(int $likesCount): self
    {
        $this->likesCount = $likesCount;
        return $this;
    }

    public function getDislikesCount(): int
    {
        return $this->dislikesCount;
    }

    public function setDislikesCount(int $dislikesCount): self
    {
        $this->dislikesCount = $dislikesCount;
        return $this;
    }

    public function getCommentsCount(): int
    {
        return $this->commentsCount;
    }

    public function setCommentsCount(int $commentsCount): self
    {
        $this->commentsCount = $commentsCount;
        return $this;
    }
}