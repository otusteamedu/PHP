<?php

namespace TimGa\Youtube;

class Video
{
    public $channelName;
    public $videoName;
    public $likes;
    public $dislikes;

    public function setChannelName(string $channelName) : void
    {
        $this->channelName = $channelName;
    }

    public function setVideoName(string $videoName) : void
    {
        $this->videoName = $videoName;
    }

    public function setLikes(int $likes) : void
    {
        $this->likes = $likes;
    }

    public function setDislikes(int $dislikes) : void
    {
        $this->dislikes = $dislikes;
    }
}
