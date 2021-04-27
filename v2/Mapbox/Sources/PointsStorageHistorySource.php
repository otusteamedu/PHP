<?php


namespace v2\Mapbox\Sources;

use v2\Mapbox\Entities\MapPoint;
use v2\Services\MapBox\Storages\DeparturePointsStorage;
use v2\Services\MapBox\Storages\DestinationPointsStorage;
use v2\Services\MapBox\Storages\PointsStorage;

class PointsStorageHistorySource implements PointsSource
{
    private PointsStorage $destinationPointsStorage;
    private PointsStorage $departurePointsStorage;

    public function __construct(DestinationPointsStorage $destinationPointsStorage, DeparturePointsStorage $departurePointsStorage)
    {
        $this->destinationPointsStorage = $destinationPointsStorage;
        $this->departurePointsStorage = $departurePointsStorage;
    }

    public function searchByAddress(string $address, int $limit = 5, int $offset = 0): array
    {
        $historyPoints = array_unique(
            array_merge(
                $this->destinationPointsStorage->getAll(),
                $this->departurePointsStorage->getAll(),
            ),
            SORT_REGULAR
        );

        return array_slice(
            array_filter(
                $historyPoints,
                static function(MapPoint $point) use ($address){
                    return stripos($point->getFullAddress(), $address);
                }
            ),
            $offset,
            $limit
        );
    }
}