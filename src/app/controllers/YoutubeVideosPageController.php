<?php

namespace Controller;

use Core\AppConfig;
use Core\AppResponse;
use Entity\YoutubeChannel;
use Entity\YoutubeVideo;
use Filter\YoutubeChannelsFilter;
use Filter\YoutubeVideosFilter;

class YoutubeVideosPageController extends PageController
{
    public function __construct(AppResponse $response, AppConfig $appConfig)
    {
        parent::__construct($response, $appConfig);

        YoutubeChannel::initStore($appConfig);
        YoutubeVideo::initStore($appConfig);
    }

    /**
     * @return YoutubeChannel
     */
    public static function getChannelInfo(): YoutubeChannel
    {
        $pageFilter = YoutubeVideosFilter::initByRequest();
        $channelsFilter = new YoutubeChannelsFilter();
        $channelsFilter->setHashId($pageFilter->getChannelId());
        $channels = YoutubeChannel::get($channelsFilter);
        return $channels[0] ?? new YoutubeChannel();
    }

    /**
     * @return YoutubeVideo[]
     */
    public static function getVideos(): array
    {
        $filter = YoutubeVideosFilter::initByRequest();
        $filter->setChannelId($filter->getChannelId());
        return YoutubeVideo::get($filter);
    }
}