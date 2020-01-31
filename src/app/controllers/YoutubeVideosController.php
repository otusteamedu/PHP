<?php

namespace Controller;

use Core\AppConfig;
use Core\AppResponse;
use Entity\YoutubeVideo;
use Filter\YoutubeVideosFilter;

class YoutubeVideosController extends JsonAppController
{
    /**
     * YoutubeChannelsController constructor.
     * @param AppResponse $response
     * @param AppConfig   $appConfig
     */
    public function __construct(AppResponse $response, AppConfig $appConfig)
    {
        parent::__construct($response, $appConfig);

        YoutubeVideo::initStore($appConfig);
    }

    /**
     * Получение Youtube канала из коллекции или их колллекции
     */
    public function get()
    {
        $filter = new YoutubeVideosFilter();
        $filter->setChannelId($_REQUEST[YoutubeVideosFilter::CHANNEL_ID]);
        $videos = YoutubeVideo::fetchList($filter);
        $this->appResponse->setContent(json_encode($videos, JSON_PRETTY_PRINT));
    }

    /**
     * Добавление Youtube канала в коллекцию
     */
    public function post()
    {
        $channel = YoutubeVideo::getInstanceByRequest();
        $channel->create();
    }

    /**
     * Изменение сведений о Youtube канале
     */
    public function update()
    {
        $this->appResponse->flush(503);
    }

    /**
     * Удаление Youtube канала из коллекции
     */
    public function delete()
    {
        $filter = YoutubeVideosFilter::initByRequest();
        $count = YoutubeVideo::deleteCollection($filter);
        $this->appResponse->setContentType(AppResponse::CONTENT_TYPE_HTML);
        $this->appResponse->setContent("Удалено $count видео");
    }
}