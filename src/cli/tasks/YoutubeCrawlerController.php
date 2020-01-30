<?php

namespace Task;

use Core\AppConfig;
use Core\AppException;
use Entity\YoutubeChannel;
use Entity\YoutubeVideo;
use Filter\YoutubeVideosFilter;

class YoutubeCrawlerController extends TaskController
{
    /**
     * @var string $channelId
     */
    private string $channelId = "";

    /**
     * @var int $counter
     */
    private static int $counter = 0;

    /**
     * AppController constructor.
     * @param AppConfig $appConfig
     */
    public function __construct(AppConfig $appConfig)
    {
        parent::__construct($appConfig);

        YoutubeChannel::initStore($appConfig);
        YoutubeVideo::initStore($appConfig);

        $this->channelId = $_REQUEST[YoutubeVideosFilter::CHANNEL_ID] ?? $argv[1] ?? "";
    }

    public function run()
    {
        $youtubeCrawlerServiceConfig = new YoutubeCrawlerServiceConfig();
        $youtubeCrawlerServiceConfig->setKey($this->appConfig->getYoutubeApiKey());

        $service = new YoutubeCrawlerService($youtubeCrawlerServiceConfig, $this->channelId);

        try {
            $service->run();

            echo ++self::$counter, " ----------------------", PHP_EOL;
            echo "+ Channel: ";
            print_r($service->getChannel());
            echo "+ Videos total count: ", count($service->getVideosCollection()), PHP_EOL;
            echo "-------------------------------", PHP_EOL;
            echo "*******************************", PHP_EOL, PHP_EOL;
        } catch (AppException $e) {
            echo $e->getMessage(), PHP_EOL;
        }
    }

    /**
     * @param string $channelId
     * @return YoutubeCrawlerController
     */
    public function setChannelId(string $channelId): YoutubeCrawlerController
    {
        $this->channelId = $channelId;
        return $this;
    }
}