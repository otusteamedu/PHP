<?php

namespace Grabbers;

class YoutubeGrabber implements Grabber
{
    public function grab (array $channelsList): void
    {
        foreach ($channelsList as $item) {
            var_dump($item);
        }
    }
}