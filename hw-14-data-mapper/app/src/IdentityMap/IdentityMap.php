<?php

namespace App\IdentityMap;

use App\Models\Model;
use App\Singleton\Singleton;

class IdentityMap extends Singleton
{
    /**
     * @var array
     */
    private array $state = [];

    /**
     * @param string $table
     * @param int    $id
     *
     * @return string
     */
    private function getKey (string $table, int $id): string
    {
        return $table . '.' . $id;
    }

    /**
     * @param string $table
     * @param Model  $obj
     */
    public static function store (string $table, Model $obj)
    {
        $map              = self::getInstance();
        $key              = $map->getKey($table, $obj->getId());
        $map->state[$key] = $obj;
    }

    /**
     * @param string $table
     * @param int    $id
     *
     * @return Model|null
     */
    public static function get (string $table, int $id): ?Model
    {
        $map = self::getInstance();
        $key = $map->getKey($table, $id);

        if (isset($map->state[$key])) {
            return $map->state[$key];
        }

        return null;
    }

    /**
     * @param string $table
     * @param int    $id
     *
     * @return bool
     */
    public static function remove (string $table, int $id): bool
    {
        $map = self::getInstance();
        $key = $map->getKey($table, $id);

        if (isset($map->state[$key])) {
            unset($map->state[$key]);

            return true;
        }

        return false;
    }

    /**
     * @param string $table
     * @param Model  $obj
     *
     * @return bool
     */
    public static function update (string $table, Model $obj): bool
    {
        $map = self::getInstance();
        $key = $map->getKey($table, $obj->getId());

        if (isset($map->state[$key])) {
            $map->state[$key] = $obj;

            return true;
        }

        return false;
    }
}