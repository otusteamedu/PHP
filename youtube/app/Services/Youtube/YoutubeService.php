<?php


namespace App\Services\Youtube;


use App\Services\Youtube\Repositories\SearchYoutubeChannelRepository;

class YoutubeService
{
    public function getChannelData(string $channel_id): array
    {
        $repository = new SearchYoutubeChannelRepository($channel_id);
        return $repository->search();
    }
}
