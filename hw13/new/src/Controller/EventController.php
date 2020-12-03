<?php


namespace AYakovlev\Controller;


use AYakovlev\Core\RedisBD;
use AYakovlev\Core\View;

class EventController
{
    private RedisBD $event;
    private RedisBD $event1;
    private RedisBD $event2;
    private RedisBD $event3;

    public function __construct()
    {
        $this->event = RedisBD::getInstance();
        $this->event1 = RedisBD::getInstance();
        $this->event2 = RedisBD::getInstance();
        $this->event3 = RedisBD::getInstance();
    }

    public function setEvent(string $property, string $name, int $priority, array $conditions): void
    {
        $this->$property->setName($name);
        $this->$property->setPriority($priority);
        $this->$property->setConditions($conditions);
    }

    public function compare(): void
    {
        $this->event->resetAllDataFromBD();
        $this->setEvent('event1', 'event1',1000, ['param1' => 1]);
        $this->event1->addNoteToBD();
        $this->setEvent('event2', 'event2', 2000, ['param1' => 2, 'param2' => 2]);
        $this->event2->addNoteToBD();
        $this->setEvent('event3','event3', 3000, ['param1' => 1, 'param2' => 1]);
        $this->event3->addNoteToBD();

        $data[0] = $this->event->getBestEventByConditions(['param1' => 1]); // event1
        $data[1] = $this->event->getBestEventByConditions(['param1' => 1, 'param2' => 1]); // event 3

        View::render('compare', $data);
    }
}
