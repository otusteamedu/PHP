<?php

namespace Bjlag\Models;

use Bjlag\App;

class Event
{
    public const TABLE = 'events';

    /**
     * @return array
     */
    public static function find(): array
    {
        return $data = App::getDb()->find(self::TABLE);
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
