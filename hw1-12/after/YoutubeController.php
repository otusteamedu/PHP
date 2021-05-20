<?php

/**
 * Class YoutubeController
 */
class YoutubeController
{
    private RepositoryInterface $repository;

    private YoutubeApiServiceInterface $youtubeApiService;

    private StatisticsYoutubeApiServiceInterface $statisticsYoutubeApiService;

    public function __construct(
        RepositoryInterface $repository,
        YoutubeApiServiceInterface $youtubeApiService,
        StatisticsYoutubeApiServiceInterface $statisticsYoutubeApiService
    ) {
        $this->repository = $repository;
        $this->youtubeApiService = $youtubeApiService;
        $this->statisticsYoutubeApiService = $statisticsYoutubeApiService;
    }

    /**
     * @throws \Exception
     */
    public function grub(): void
    {
        foreach ($this->getChannelsList() as $channelId) {
            $channelDto = $this->youtubeApiService->getChannelsInfo($channelId);
            if ($this->repository->save($channelDto, Channel::TABLE_NAME)) {
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
        $videos = $this->youtubeApiService->getChannelVideos($channelId);
        foreach ($videos as $videoDTO) {
            $this->repository->save($videoDTO, Video::TABLE_NAME);
        }
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getStatisticsChannelVideos(): string
    {
        $allChannels = $this->repository->getAllChannels();

        $statistics = [];

        foreach ($allChannels as $channel) {
            $statistics[] = $this->statisticsYoutubeApiService->getStats($channel->id);
        }

        return json_encode($statistics, JSON_FORCE_OBJECT);
    }

    /**
     * @throws \Exception
     */
    public function delete(): void
    {
        $this->repository->dropIndex();
    }
}
