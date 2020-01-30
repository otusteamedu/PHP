<?php

namespace Controller;

use Core\AppConfig;
use Core\AppException;
use Core\AppResponse;
use Entity\Event;
use Filter\EventsFilter;

class EventsManagerPageController extends PageController
{
    /**
     * EventsPageController constructor.
     * @param AppResponse $response
     * @param AppConfig   $appConfig
     * @throws AppException
     */
    public function __construct(AppResponse $response, AppConfig $appConfig)
    {
        parent::__construct($response, $appConfig);

        Event::initStore($appConfig);
    }

    /**
     * @return Event[]
     */
    public static function getEventsList(): array
    {
        $filter = EventsFilter::initByRequest();
        return Event::get($filter);
    }

    public static function getEventConditionPrefix()
    {
        return EventsFilter::CONDITION;
    }
}