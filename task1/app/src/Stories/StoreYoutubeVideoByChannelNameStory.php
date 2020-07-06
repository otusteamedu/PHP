<?php

namespace App\Stories;

use App\Repository\YoutubeChannelQueryRepository;
use App\Repository\YoutubeVideoCommandRepository;
use App\Services\YouTubeInfoFetcher;

class StoreYoutubeVideoByChannelNameStory implements Story
{
    private YoutubeChannelQueryRepository $queryRepository;
    private YoutubeVideoCommandRepository $commandRepository;
    private YouTubeInfoFetcher $fetcher;

    public function __construct()
    {
        $this->queryRepository = new YoutubeChannelQueryRepository();
        $this->fetcher = new YouTubeInfoFetcher();
        $this->commandRepository = new YoutubeVideoCommandRepository();
    }

    public function execute($data = null)
    {
        $channelId = $this->queryRepository->getByChannelName($data)->channelId;
        if (!$channelId) {
            $channelId = $this->fetcher->getChannelInfoByChannelName($data)->items[0]->id;
        }
        $videoIds = $this->fetcher->getChannelVideoIds($channelId);
        if (!$videoIds) {
            throw new \Exception('Нет подходящих видео для сбора статистики');
        }
        foreach ($videoIds as $key => $videoId) {
            $videoData[] = $this->fetcher->getVideosStatistic($videoId);
        }
        foreach ($videoData as $key => $video) {
            $this->commandRepository->create($video->items[0]);
        }
        return true;
    }
}
