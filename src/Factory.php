<?php

namespace crazydope\youtube;

class Factory
{
    public function buildChannel(string $title, string $link, string $description = ''): ChannelInterface
    {
        $chanel = new Channel();
        $chanel
            ->setTitle($title)
            ->setLink($link)
            ->setDescription($description);

        return $chanel;
    }


    public function buildVideo(string $channelId, string $videoTitle, string $link, int $likes, int $dislikes): VideoInterface
    {
        $video = new Video();
        $video
            ->setTitle($videoTitle)
            ->setLink($link)
            ->setLikeCount($likes)
            ->setDislikeCount($dislikes)
            ->setChannelId($channelId);

        return $video;
    }
}