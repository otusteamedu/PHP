<?php

namespace Grabbers;

use Youtube\YoutubeClient;

class YoutubeGrabber implements Grabber
{
    public function grab (array $channelsList): void
    {
        foreach ($channelsList as $channelId) {
            echo $channelId . PHP_EOL;

            $client     = new YoutubeClient();
            $channelDTO = $client->getChannelData($channelId);
        }
    }
}