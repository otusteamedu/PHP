<?php

namespace Controller;

use Core\AppConfig;
use Core\AppResponse;
use Entity\YoutubeChannel;
use Entity\YoutubeChannelStatistics;
use Entity\YoutubeVideo;
use Filter\YoutubeChannelsFilter;

class YoutubeTopChannelsPageController extends PageController
{
    /** @var YoutubeChannelsFilter $filter */
    protected static YoutubeChannelsFilter $filter;

    /**
     * YoutubeTopChannelsPageController constructor.
     * @param AppResponse $response
     * @param AppConfig   $appConfig
     */
    public function __construct(AppResponse $response, AppConfig $appConfig)
    {
        parent::__construct($response, $appConfig);

        YoutubeChannel::initStore($appConfig);
        YoutubeVideo::initStore($appConfig);

        self::$filter = YoutubeChannelsFilter::initByRequest();
    }

    /**
     * @return int
     */
    public static function getChartValue(): int
    {
        return self::$filter->getLimit();
    }

    /**
     * @return YoutubeChannelStatistics[]
     */
    public static function getTopChannels(): array
    {
        return YoutubeChannel::getTopChannelsStatistics(self::$filter->getLimit());
    }
}