<?php


namespace App\Controllers;


use App\Services\YoutubeStatisticHandler;
use App\Stories\StoreYoutubeChannelByNameStory;
use App\Stories\StoreYoutubeVideoByChannelNameStory;

class YoutubeController
{
    public function saveChannel($request, StoreYoutubeChannelByNameStory $story)
    {
        return $story->execute($request);
    }

    public function saveVideo($request, StoreYoutubeVideoByChannelNameStory $story)
    {
        return $story->execute($request);
    }

    public function getTopChannels($request, YoutubeStatisticHandler $service)
    {
        return $service->getTopChannels($request);
    }

    public function getRatingList($request, YoutubeStatisticHandler $service)
    {
        return $service->getRatingList($request);
    }

}