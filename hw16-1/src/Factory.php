<?php

namespace TimGa\Youtube;

class Factory
{
    public function createChannel(string $name, string $description, string $author) : Channel
    {
        $channel = new Channel();
        $channel->setName($name);
        $channel->setDescription($description);
        $channel->setAuthor($author);
        return $channel;
    }

    public function createVideo(string $channelName, string $videoName, int $likes, int $dislikes) : Video
    {
        $video = new Video();
        $video->setChannelName($channelName);
        $video->setVideoName($videoName);
        $video->setLikes($likes);
        $video->setDislikes($dislikes);
        return $video;
    }
}
