<?php

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
        $youtubeApiService = new YoutubeApiYoutubeApiService();
        foreach ($this->getChannelsList() as $channelId) {
            $channelDto = $youtubeApiService->getChannelsInfo($channelId);
            $elasticSearchRepository = new ElasticSearchRepository();
            if ($elasticSearchRepository->save($channelDto, Channel::TABLE_NAME)) {
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
        $youtubeApiService = new YoutubeApiYoutubeApiService();
        $videos = $youtubeApiService->getChannelVideos($channelId);

        $elasticSearchRepository = new ElasticSearchRepository();
        foreach ($videos as $videoDTO) {
            $elasticSearchRepository->save($videoDTO, Video::TABLE_NAME);
        }
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getStatisticsChannelVideos(): string
    {
        $statisticsService = new StatisticsYoutubeApiService();
        $allChannels = (new ElasticSearchRepository())->getAllChannels();

        $statistics = [];

        foreach ($allChannels as $channel) {
            $statistics[] = $statisticsService->getStats($channel->id);
        }

        return json_encode($statistics, JSON_FORCE_OBJECT);
    }

    /**
     * @throws \Exception
     */
    public function delete(): void
    {
        (new ElasticSearchRepository())->dropIndex();
    }
}
