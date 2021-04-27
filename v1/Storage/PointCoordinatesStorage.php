<?php

namespace App\Services\Storage;

/**
 * Class PointCoordinatesStorage
 * Storage points by unique key - coordinates. Stored points in MapPoint object.
 * @package App\Extensions\Mapbox
 */
class PointCoordinatesStorage extends RedisStorage
{
    protected static $storageName = 'mapbox';

    public static function save(string $key,  $point)
    {
        $storage = self::getStorage();
        return $storage->add($key, $point, self::$storageTime);
    }
}