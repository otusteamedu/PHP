<?php

namespace Controller;

use Core\AppConfig;
use Core\AppResponse;
use Entity\YoutubeChannel;
use Entity\YoutubeVideo;
use Filter\YoutubeChannelsFilter;
use Filter\YoutubeVideosFilter;

class YoutubeChannelsController extends JsonAppController
{

    /**
     * YoutubeChannelsController constructor.
     * @param AppResponse $response
     * @param AppConfig   $appConfig
     */
    public function __construct(AppResponse $response, AppConfig $appConfig)
    {
        parent::__construct($response, $appConfig);

        YoutubeChannel::initStore($appConfig);
    }

    /**
     * Получение Youtube канала из коллекции или их колллекции
     */
    public function get()
    {
        $filter = new YoutubeChannelsFilter();
        $channels = YoutubeChannel::fetchList($filter);
        $this->appResponse->setContent(json_encode($channels));
    }

    /**
     * Добавление Youtube канала в коллекцию
     */
    public function post()
    {
        $channel = YoutubeChannel::getInstanceByRequest();
        if ($channel->create()) {
            $this->appResponse->setContent(json_encode($channel->fetchDocument()));
        } else {
            $this->appResponse->setContent("couldn't save channel");
        }
    }

    /**
     * Изменение сведений о Youtube канале
     */
    public function update()
    {
        $this->appResponse->setCode(502);
    }

    /**
     * Удаление Youtube канала из коллекции
     */
    public function delete()
    {
        $chFilter = YoutubeChannelsFilter::initByRequest();
        $chCount = YoutubeChannel::deleteCollection($chFilter);

        YoutubeVideo::initStore($this->appConfig);
        $vFilter = new YoutubeVideosFilter();
        $vFilter->setChannelId($chFilter->getHashId());
        $vCount = YoutubeVideo::deleteCollection($vFilter);

        $this->appResponse->setContent("Удалено $chCount каналов, $vCount видео");
    }

    /**
     * CSV список ID каналов для добавления в БД
     */
    public function import()
    {
        $channelsIdList = $_POST["list"] ?? "";

        header("Content-Type: text/plain; charset=utf-8");
        echo passthru("php /var/www/html/cli/youtube-crawler.php $channelsIdList");
        exit;
    }
}