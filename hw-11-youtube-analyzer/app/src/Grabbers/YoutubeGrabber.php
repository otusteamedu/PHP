<?php

namespace App\Grabbers;

use App\Clients\YoutubeClient;
use App\Log\Log;
use App\Models\Channel;
use App\Models\DTO\ChannelDTO;
use App\Models\Video;
use Monolog\Logger;

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
                    $this->grabVideos($channel->getId());
                }
                else {
                    Log::getInstance()->addRecord('not stored channel ' . $channelId, Logger::ERROR);
                }
            }
        }
    }

    private function grabVideos (string $channelId)
    {
        $logger = Log::getInstance();

        $logger->addRecord('grabbing videos from channel ' . $channelId);

        $client = new YoutubeClient();
        $videos = $client->getChannelVideos($channelId);

        $logger->addRecord(count($videos) . ' videos was grabbed from channel. saving...');

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
            $logger->addRecord('success');
        }
        else {
            $logger->addRecord('some videos are not stored', Logger::ERROR);
        }
    }
}