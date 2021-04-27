<?php


namespace v2\Mapbox\Sources;


use v2\Mapbox\Entities\MapPoint;
use v2\Services\MapBox\Storages\PointsCollectionStorage;
use v2\Services\MapBox\Storages\PointsStorage;

class PointsStorageCollectionSource implements PointsSource
{
    private PointsStorage $storage;

    public function __construct(PointsCollectionStorage $storage)
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