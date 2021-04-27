<?php

namespace App\Services\Mapbox;

use App\Services\Storage\PointCoordinatesStorage;

class Mapbox
{
    /**
     * Get Point from PointCoordinatesStorage if exists or MapboxApi, if not found, return false
     * @var $coordinates - string
     * @return MapPoint|false
     */
    public function getPointByCoordinates($coordinates)
    {
        $point = PointCoordinatesStorage::get($coordinates);
        if($point){
            return $point;
        }

        $point = resolve(MapboxApi::class)->getPointByCoordinates($coordinates);
        if($point){
            PointCoordinatesStorage::save($coordinates, $point);
        }

        return $point;
    }

    /**
     * Get Point from PointCoordinatesStorage if exists or MapboxApi, if not found, return false
     * @var $address - string
     * @return MapPoint|false
     */
    public function getPointByAddress($address)
    {
        $point = resolve(MapboxApi::class)->getPointByAddress($address);
        if(!$point){
            return $point;
        }

        if(!PointCoordinatesStorage::get($point->coordinates)){
            PointCoordinatesStorage::save($point->coordinates, $point);
        };

        return $point;
    }

    /**
     * Get array MapPoints from PointCoordinatesStorage if exists or MapboxApi, if not found, return empty array
     * @var $address - string
     * @return array
     */
    public function getPointsByAddress($address)
    {
        $points = resolve(MapboxApi::class)->getPointsByAddress($address);
        if(!$points){
            return $points;
        }

        return $points;
    }
}