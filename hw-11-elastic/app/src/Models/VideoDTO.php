<?php

namespace Models;

class VideoDTO extends DTO
{
    public string $id;
    public string $title;
    public string $channelId;
    public int    $viewCount;
    public int    $likeCount;
    public int    $dislikeCount;
    public int    $commentCount;

    public function __construct (
        string $id,
        string $title,
        string $channelId,
        int    $viewCount,
        int    $likeCount,
        int    $dislikeCount,
        int    $commentCount
    )
    {
        $this->id           = $id;
        $this->title        = $title;
        $this->channelId    = $channelId;
        $this->viewCount    = $viewCount;
        $this->likeCount    = $likeCount;
        $this->dislikeCount = $dislikeCount;
        $this->commentCount = $commentCount;
    }
}