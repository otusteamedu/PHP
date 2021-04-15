<?php

namespace Src\DTO;

/**
 * Class VideoDTO
 *
 * @package Src\DTO
 */
class VideoDTO
{
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
}
