<?php

namespace Bjlag\Models;

use Bjlag\App;

class Event
{
    public const TABLE = 'events';

    public const FIELD_PRIORITY = 'priority';
    public const FIELD_CONDITIONS = 'conditions';

    /**
     * @return array
     */
    public static function find(): array
    {
        return $data = App::getDb()->find(self::TABLE);
    }

    /**
     * @param array $params
     * @return array
     */
    public static function findByParams(array $params): array
    {
        $result = [];
        $paramsCount = count($params);
        $priorityPrev = null;

        $events = Event::find();
        foreach ($events as $key => $event) {
            $eventData = json_decode($event, true);
            $priority = $eventData[self::FIELD_PRIORITY];
            $conditions = $eventData[self::FIELD_CONDITIONS];

            if ($paramsCount !== count($conditions)) {
                continue;
            }

            $diff = array_diff_assoc($params, $conditions);
            if (count($diff) === 0) {
                if ($priority > $priorityPrev) {
                    $result = $eventData;
                    $priorityPrev = $priority;
                }
            }
        }

        return $result;
    }

    /**
     * @param string $key
     * @param array $data
     * @return int
     */
    public static function add(string $key, array $data): int
    {
       return App::getDb()->add(self::TABLE, [$key => $data]);
    }

    /**
     * @param string $name
     * @return int
     */
    public static function delete(string $name): int
    {
        return App::getDb()->delete(self::TABLE, [$name]);
    }

    /**
     * @return int
     */
    public static function deleteAll(): int
    {
        return App::getDb()->deleteAll(self::TABLE);
    }
}
