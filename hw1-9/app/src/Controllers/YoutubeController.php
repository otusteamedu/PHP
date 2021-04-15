<?php

namespace Src\Controllers;

use Src\Messages\Responser;
use Src\Models\Channel;
use Src\Models\Video;
use Src\Services\YoutubeApiService;
use Src\Storage\ElasticSearchStorage;

/**
 * Class YoutubeController
 */
class YoutubeController
{
    /**
     * @throws \Exception
     */
    public function grub(): void
    {
        $youtubeApiService = new YoutubeApiService();
        foreach ($this->getChannelsList() as $channelId) {
            $channelDto = $youtubeApiService->getChannelsInfo($channelId);
            $storage = new ElasticSearchStorage();
            if ($storage->store($channelDto, Channel::TABLE_NAME)) {
                $this->grabVideos($channelId);
            } else {
                Responser::responseFail('Channel info is not saved');
            }
        }
        Responser::responseOk();
    }

    /**
     * @return array|bool
     */
    private function getChannelsList()
    {
        return file($_SERVER['DOCUMENT_ROOT'] . '/channels.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }

    /**
     * @param string $channelId
     *
     * @throws \Exception
     */
    private function grabVideos(string $channelId): void
    {
        $youtubeApiService = new YoutubeApiService();
        $videos = $youtubeApiService->getChannelVideos($channelId);

        $storage = new ElasticSearchStorage();
        foreach ($videos as $videoDTO) {
            $storage->store($videoDTO, Video::TABLE_NAME);
        }
    }


}