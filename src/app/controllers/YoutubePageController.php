<?php

namespace Controller;

use Core\AppConfig;
use Core\AppResponse;
use Entity\YoutubeChannel;
use Entity\YoutubeVideo;
use Filter\YoutubeChannelsFilter;

class YoutubePageController extends AppController
{
    public function __construct(AppResponse $response, AppConfig $appConfig)
    {
        parent::__construct($response, $appConfig);

        YoutubeChannel::initStore($appConfig);
        YoutubeVideo::initStore($appConfig);
    }

    /**
     * @return YoutubeChannel[]
     */
    public static function getYoutubeChannels(): array
    {
        $filter = new YoutubeChannelsFilter();
        return YoutubeChannel::get($filter);
    }

    /**
     * @param int|null $count
     * @return string
     */
    public static function getChannelsHashIdList(?int &$count = 0): string
    {
        if (!empty($str = file_get_contents(__DIR__ . "/../data/channels.txt"))) {
            $count = count(explode(",", $str));
        }
        return $str;
    }
}