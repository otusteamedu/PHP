<?php

namespace Controller;

use Core\AppConfig;
use Core\AppException;
use Core\AppResponse;
use Entity\Event;
use Filter\EventsFilter;

class PriorityEventPageController extends PageController
{
    private static $pageFilter;

    /**
     * PriorityEventPageController constructor.
     * @param AppResponse $response
     * @param AppConfig   $appConfig
     * @throws AppException
     */
    public function __construct(AppResponse $response, AppConfig $appConfig)
    {
        parent::__construct($response, $appConfig);

        Event::initStore($appConfig);
        self::$pageFilter = EventsFilter::initByRequest();
    }

    /**
     * @return Event
     */
    public static function getEvent(): Event
    {
        return Event::getByMaxPriority(self::$pageFilter);
    }

    /**
     * @return string
     */
    public static function getFilterAsString(): string
    {
        return http_build_query(self::$pageFilter->fetch(), null, ", ") ?: "Фильтр не задан";
    }
}