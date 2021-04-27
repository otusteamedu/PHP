<?php


namespace v2\Mapbox\Managers;


use v2\Mapbox\Entities\MapPoint;
use v2\Services\MapBox\Storages\PointsStorage;

class MapBoxPointsSaver
{
    /**
     * @var array|PointsStorage[]
     */
    private array $storages = [];

    public function addStorage(PointsStorage $pointsStorage) : void
    {
        $this->storages[] = $pointsStorage;
    }

    public function clearStorages() : void
    {
        $this->storages = [];
    }

    public function savePoint(MapPoint $point) : void
    {
        foreach($this->storages as $storage){
           $storage->save($point);
        }
    }
}