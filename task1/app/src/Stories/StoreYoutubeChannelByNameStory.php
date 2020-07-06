<?php


namespace App\Stories;


use App\Repository\YoutubeChannelCommandRepository;
use App\Services\YouTubeInfoFetcher;

class StoreYoutubeChannelByNameStory implements Story
{
    private YoutubeChannelCommandRepository $commandRepository;
    private YouTubeInfoFetcher $fetcher;

    public function __construct()
    {
        $this->commandRepository = new YoutubeChannelCommandRepository();
        $this->fetcher = new YouTubeInfoFetcher();
    }

    public function execute($data = null)
    {
        $fetchData = $this->fetcher->getChannelInfoByChannelName($data);
        if (!$fetchData) {
            return null;
        }
        $videoIds = $this->fetcher->getChannelVideoIds($fetchData->items[0]->id);
        if (!$videoIds) {
            return null;
        }
        return $this->commandRepository->create($fetchData->items[0], $videoIds);
    }
}