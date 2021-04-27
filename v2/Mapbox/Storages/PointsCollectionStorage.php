<?php


namespace v2\Services\MapBox\Storages;

use v2\Mapbox\Entities\MapPoint;
use v2\Services\Storage\Storage;

class PointsCollectionStorage implements PointsStorage
{
    protected Storage $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function save(MapPoint $point) : void
    {
        $points = $this->getAll();
        if(!in_array($point, $points, true)){
            $points[] = $point;
        }
        $this->storage->set($this->getKey(), $points);
        $this->storage->set($this->getKey().$point->getId(), $points);
    }

    public function getById(int $id) : ?MapPoint
    {
        return $this->storage->get($this->getKey().$id);
    }

    public function getAll() : array
    {
       return $this->storage->get($this->getKey(), []);
    }

    protected function getKey() : string
    {
        return 'map_points';
    }
}