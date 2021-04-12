<?php

declare(strict_types=1);

namespace App\Service\YouTube\Dto;

class VideoDto
{

    public string $id;
    public string $title;
    public string $channelId;
    public int    $likeCount;
    public int    $dislikeCount;

    public function __construct(string $id, string $title, string $channelId)
    {
        $this->id = $id;
        $this->title = $title;
        $this->channelId = $channelId;
    }

}