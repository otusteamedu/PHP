<?php

namespace Ozycast\App\Models;

use Ozycast\App\App;

Class Event
{
    public $id = 0;
    public $priority = 0;
    public $conditions = [];
    public $event = [];

    public static function getCollectName(): string
    {
        return "Events";
    }

    /**
     * Добавить собития
     * @param array $events
     * @return array
     */
    public static function addEvents(array $events): array
    {
        foreach ($events as $event) {
            $event = (new Event())->serialize($event);
            $event->id = App::$cache->connect->hlen(Event::getCollectName()) + 1;
            App::$cache->connect->hset(Event::getCollectName(), $event->id, json_encode($event));

            // Добавим параметры
            foreach ($event->conditions as $key => $condition) {
                $name = $key."=".$condition;
                App::$cache->connect->sadd($name, $event->id);
            }
        }

        return ['status' => 1, 'message' => 'Done!'];
    }

    /**
     * Найти подходящее события по параметрам
     * @param array $params
     * @return array
     */
    public static function findEvents(array $params): array
    {
        $sets = [];
        foreach ($params as $key => $value) {
            $sets[] = $key . "=" . $value;
        }
        $event_ids = App::$cache->connect->sinter($sets);
        $events = App::$cache->connect->hmget(Event::getCollectName(), $event_ids);
        if (empty($event_ids))
            return ['status' => 0, 'message' => 'Events not found'];

        $eventReturn = $events[0];
        foreach ($events as &$event) {
            $event = json_decode($event, JSON_OBJECT_AS_ARRAY);
            if ($event['priority'] > $eventReturn['priority'])
                $eventReturn = $event;
        }

        return ['status' => 1, 'message' => 'Done!', 'data' => $eventReturn];
    }

    /**
     * Вернуть все события
     * @return array
     */
    public static function events()
    {
        $events = App::$cache->connect->HGETALL(Event::getCollectName());
        return ['status' => 1, 'message' => 'Done!', 'data' => $events];
    }

    /**
     * @param array $data
     * @return Event
     */
    public function serialize(array $data): Event
    {
        if (empty($data))
            return $this;

        foreach (get_class_vars(get_class($this)) as $key => $param) {
            if (isset($data[$key]))
                $this->$key = $data[$key];
        }

        return $this;
    }
}