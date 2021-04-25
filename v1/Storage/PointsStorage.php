<?php


namespace App\Services\Storage;

/**
 * Class PointsStorage
 * Storage all mapbox points for one kye. Stored point in format MapPoint object.
 * @package App\Extensions\Mapbox
 */
class PointsStorage extends RedisStorage
{
    const KEY = 'map_points';
    protected static $storageName = 'points';

    public static function savePoint($point)
    {
        $points = self::get(self::KEY) ?: [];
        if(array_search($point, $points) === false){
            array_push($points, $point);
        }
        self::save(self::KEY, $points);
    }
}