<?php


namespace RedisApp;


use RedisApp\EventModel;


class View
{
    private EventModel $eventToPrint;
    private array $ev1;
    private array $ev2;

    public function __construct()
    {
        $this->eventToPrint = new EventModel();
    }

    public function getEventToPrint(): \RedisApp\EventModel
    {
        return $this->eventToPrint;
    }

    public function getEv1(): array
    {
        return $this->ev1;
    }

    public function getEv2(): array
    {
        return $this->ev2;
    }

    public function view()
    {
        $this->ev1 = $this->eventToPrint->getBestEventByConditions(['param1' => 1]); // event1
        $this->ev2 = $this->eventToPrint->getBestEventByConditions(['param1' => 1, 'param2' => 1]); // event 3
    }

}
