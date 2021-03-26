<?php

namespace App\Grabbers;

use App\Log\Log;
/*use Models\Channel;
use Models\ChannelDTO;
use Models\Video;*/
use Monolog\Logger;
/*use Storage\Storage;
use Youtube\YoutubeClient;*/

class YoutubeGrabber implements Grabber
{
    public function grab (array $channelsList): void
    {
        foreach ($channelsList as $channelId) {
            Log::getInstance()->addRecord('grabbing channel ' . $channelId, Logger::INFO);
        }
    }

    /*private function grabVideos (string $channelId)
    {
        echo 'grabbing videos from channel ' . $channelId . PHP_EOL;

        $client = new YoutubeClient();
        $videos = $client->getChannelVideos($channelId);

        echo count($videos) . ' videos was grabbed from channel. saving...' . PHP_EOL;

        $result = true;

        foreach ($videos as $videoDTO) {
            $video = new Video(
                $videoDTO->id,
                $videoDTO->title,
                $videoDTO->channelId,
                $videoDTO->viewCount,
                $videoDTO->likeCount,
                $videoDTO->dislikeCount,
                $videoDTO->commentCount
            );

            $result = $video->store($videoDTO);
        }

        if ($result === true) {
            echo 'success' . PHP_EOL;
        }
        else {
            echo 'some videos are not stored' . PHP_EOL;
        }
    }*/
}