<?php

namespace App\Grabbers;

use App\Clients\YoutubeClient;
use App\Log\Log;
use App\Models\Channel;
use App\Models\DTO\ChannelDTO;
use App\Models\Video;
use App\Storage\Storage;
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
                $result = Storage::getInstance()->getStorage()->store($channelDTO, Channel::TABLE_NAME);

                if ($result === true) {
                    Log::getInstance()->addRecord('success grabbing channel ' . $channelId);
                    $this->grabVideos($channelId);
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
            $result = Storage::getInstance()->getStorage()->store($videoDTO, Video::TABLE_NAME);
        }

        if ($result === true) {
            $logger->addRecord('success');
        }
        else {
            $logger->addRecord('some videos are not stored', Logger::ERROR);
        }
    }
}