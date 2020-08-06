<?php


namespace AYakovlev\Controller;


use AYakovlev\Core\View;
use AYakovlev\Model\EventModel;

class EventController
{
    private static object $property;

    private static function setEvent(string $name, int $priority, array $conditions): void
    {
        self::$property->setName($name);
        self::$property->setPriority($priority);
        self::$property->setConditions($conditions);
    }

    public function compare(): void
    {
        $event = EventModel::getInstance('event');
        $event->resetAllDataFromBD();

        $events = (require 'inputData.php')['events'];

        foreach ($events as $event) {
            self::$property = EventModel::getInstance('event');
            static::setEvent($event['name'], $event['priority'], $event['conditions']);
            self::$property->addNoteToBD();
        }

        $event = EventModel::getInstance();
        $data[0] = $event->getBestEventByConditions(['param1' => 1]); // event1
        $data[1] = $event->getBestEventByConditions(['param1' => 1, 'param2' => 1]); // event 3

        View::render('compare', $data);
    }
}
