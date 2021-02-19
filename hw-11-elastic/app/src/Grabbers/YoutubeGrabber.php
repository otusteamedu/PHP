<?php

namespace Grabbers;

use Models\ChannelDTO;
use Storage\Storage;
use Youtube\YoutubeClient;

class YoutubeGrabber implements Grabber
{
    public function grab (array $channelsList): void
    {
        foreach ($channelsList as $channelId) {
            echo 'grabbing channel ' . $channelId . PHP_EOL;

            $client     = new YoutubeClient();
            $channelDTO = $client->getChannelData($channelId);

            if ($channelDTO instanceof ChannelDTO) {
                $result = Storage::getInstance()->getStorage()->store($channelDTO);

                if ($result === true) {
                    echo 'success' . PHP_EOL;
                    $this->grabVideos($channelId);
                }
                else {
                    echo 'not stored' . PHP_EOL;
                }
            }
        }
    }

    private function grabVideos (string $channelId)
    {
        echo 'grabbing videos from channel ' . $channelId . PHP_EOL;

        $client = new YoutubeClient();
        $videos = $client->getChannelVideos($channelId);

        echo count($videos) . ' videos was grabbed from channel. saving...' . PHP_EOL;

        $result = true;

        foreach ($videos as $videoDTO) {
            $result = Storage::getInstance()->getStorage()->store($videoDTO);
        }

        if ($result === true) {
            echo 'success' . PHP_EOL;
        }
        else {
            echo 'some videos are not stored' . PHP_EOL;
        }
    }
}