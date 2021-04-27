<?php


namespace v2\Mapbox\Sources;

use v2\Mapbox\Entities\MapPoint;
use v2\Services\MapBox\Storages\DestinationPointsStorage;
use v2\Services\MapBox\Storages\PointsStorage;

class DestinationPointsStorageSource implements PointsSource
{
    private PointsStorage $storage;

    public function __construct(DestinationPointsStorage $storage)
    {
        $this->storage = $storage;
    }

    public function searchByAddress(string $address, int $limit = 5, int $offset = 0): array
    {
        return array_slice(
            array_filter(
                $this->storage->getAll(),
                static function(MapPoint $point) use ($address){
                    return stripos($point->getFullAddress(), $address);
                }
            ),
            $offset,
            $limit
        );
    }
}