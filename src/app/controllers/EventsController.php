<?php

namespace Controller;

use Core\AppConfig;
use Core\AppException;
use Core\AppResponse;
use Entity\Event;
use Filter\EventsFilter;

class EventsController extends JsonAppController
{
    /**
     * EventsController constructor.
     * @param AppResponse $response
     * @param AppConfig   $appConfig
     * @throws AppException
     */
    public function __construct(AppResponse $response, AppConfig $appConfig)
    {
        parent::__construct($response, $appConfig);

        Event::initStore($appConfig);
    }

    public function get()
    {
        $eventsFilter = EventsFilter::initByRequest();
        $eventsList = Event::fetchList($eventsFilter);
        $this->appResponse->setContent(json_encode($eventsList));
    }

    public function getPriorityEvent()
    {
        $eventsFilter = EventsFilter::initByRequest();
        $event = Event::getByMaxPriority($eventsFilter);
        $this->appResponse->setContent(json_encode($event->fetchDocument()));
    }

    public function post()
    {
        $event = Event::getInstanceByRequest();
        $event->create();
        $this->appResponse->setContent(json_encode($event->fetchDocument()));
    }

    public function delete()
    {
        if (Event::deleteCollection(new EventsFilter())) {
            $this->appResponse->setContent("события удалены");
        } else {
            $this->appResponse->setContent("не удалось удалить события");
        }
    }
}