<?php


namespace RedisApp;


class Controller
{
    private EventModel $event;
    private EventModel $event1;
    private EventModel $event2;
    private EventModel $event3;

    public function __construct()
    {
        $this->event = new EventModel();
        $this->event1 = new EventModel();
        $this->event2 = new EventModel();
        $this->event3 = new EventModel();
    }

    public function setEvent1(): void
    {
        $this->event1->setName('event1');
        $this->event1->setPriority('1000');
        $this->event1->setConditions(['param1' => 1]);
    }

    public function setEvent2(): void
    {
        $this->event2->setName('event2');
        $this->event2->setPriority('2000');
        $this->event2->setConditions(['param1' => 2, 'param2' => 2]);
    }

    public function setEvent3(): void
    {
        $this->event3->setName('event3');
        $this->event3->setPriority('3000');
        $this->event3->setConditions(['param1' => 1, 'param2' => 1]);
    }

    public function getEvent1(): \RedisApp\iEventModel
    {
        return $this->event1;
    }

    public function getEvent2(): \RedisApp\iEventModel
    {
        return $this->event2;
    }

    public function getEvent3(): \RedisApp\iEventModel
    {
        return $this->event3;
    }

    public function run(): void
    {
        $this->event->resetAllDataFromBD();
        $this->setEvent1();
        $this->event1->addNoteToBD();
        $this->setEvent2();
        $this->event2->addNoteToBD();
        $this->setEvent3();
        $this->event3->addNoteToBD();
    }
}
