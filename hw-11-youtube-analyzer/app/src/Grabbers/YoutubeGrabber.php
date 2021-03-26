<?php

namespace App\Grabbers;

use App\Clients\YoutubeClient;
use App\Log\Log;
/*
use Models\Video;*/

use App\Models\Channel;
use App\Models\DTO\ChannelDTO;
use Monolog\Logger;
/*use Storage\Storage;*/

class YoutubeGrabber implements Grabber
{
    public function grab (array $channelsList): void
    {
        foreach ($channelsList as $channelId) {
            Log::getInstance()->addRecord('grabbing channel ' . $channelId);

            $client     = new YoutubeClient();
            $channelDTO = $client->getChannelData($channelId);

            if ($channelDTO instanceof ChannelDTO) {
                $channel = new Channel(
                    $channelDTO->id,
                    $channelDTO->title,
                    $channelDTO->description,
                    $channelDTO->thumbnail
                );

                $result = $channel->store($channelDTO);

                if ($result === true) {
                    Log::getInstance()->addRecord('success grabbing channel ' . $channelId);
                    //$this->grabVideos($channel->getId());
                }
                else {
                    //echo 'not stored' . PHP_EOL;
                }
            }
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