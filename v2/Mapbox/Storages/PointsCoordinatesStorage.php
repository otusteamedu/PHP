<?php


namespace v2\Services\MapBox\Storages;

class PointsCoordinatesStorage extends PointsCollectionStorage
{
    protected function getKey() : string
    {
        return 'map_box_coordinates';
    }
}