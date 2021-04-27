<?php


namespace App\Services\Storage;

use App\Services\Mapbox\MapPoint;
use Illuminate\Support\Facades\Auth;

/**
 * Class PointHistoryStorage
 * Storage for history users selected points.
 * @package App\Extensions\Mapbox
 */
class PointHistoryStorage extends RedisStorage
{
    const DEPARTURE_POINTS_KEY = 'departure_points';
    const DESTINATION_POINTS_KEY = 'destination_points';
    const MAX_LENGTH_HISTORY = 10;

    protected static $storageName = 'history';

    /**
     * @param MapPoint $point
     */
    public static function saveDeparturePoint(MapPoint $point)
    {
        if(!Auth::id()){
            return;
        }
        $points = self::getDeparturePoints();
        $point->recent = true;
        if(array_search($point, $points) !== false){
            return;
        }
        $points = self::checkLength($points);
        array_push($points, $point);
        self::save(self::DEPARTURE_POINTS_KEY.Auth::id(), $points);
    }

    /**
     * @param MapPoint $point
     */
    public static function saveDestinationPoint(MapPoint $point)
    {
        if(!Auth::id()){
            return;
        }
        $points = self::getDestinationPoints();
        $point->recent = true;
        if(array_search($point, $points) !== false){
            return;
        }

        $points = self::checkLength($points);
        array_push($points, $point);
        self::save(self::DESTINATION_POINTS_KEY.Auth::id(), $points);
    }

    public static function getDeparturePoints()
    {
        if(!Auth::id()){
            return [];
        }
        return self::get(self::DEPARTURE_POINTS_KEY.Auth::id()) ?? [];
    }

    public static function getDestinationPoints()
    {
        if(!Auth::id()){
            return [];
        }
        return self::get(self::DESTINATION_POINTS_KEY.Auth::id()) ?? [];
    }

    public static function getHistoryPoints()
    {
        return array_unique(array_merge(self::getDeparturePoints(), self::getDestinationPoints()), SORT_REGULAR);
    }

    private static function checkLength(array $points)
    {
        if(count($points) >= self::MAX_LENGTH_HISTORY){
            array_slice($points, 0,1);
        }
        return $points;
    }
}