<?php


namespace v2\Mapbox\Managers;


use v2\Mapbox\Entities\MapPoint;
use v2\Mapbox\MapBoxConfig;
use v2\Mapbox\Sources\PointsApiSource;
use v2\Mapbox\Sources\PointsByLocationApiSource;
use v2\Mapbox\Sources\PointsByLocationStorageCollectionSource;
use v2\Mapbox\Sources\PointsStorageCollectionSource;
use v2\Mapbox\Sources\PointsStorageHistorySource;
use v2\Services\MapBox\Storages\DeparturePointsStorage;
use v2\Services\MapBox\Storages\DestinationPointsStorage;
use v2\Services\MapBox\Storages\PointsCollectionStorage;
use v2\Services\MapBox\Storages\PointsCoordinatesStorage;

final class MapBox
{
    private MapBoxPointsSaver $mapBoxPointsSaver;
    private MapBoxPointsSearcher $mapBoxPointsSearcher;

    private const DEFAULT_SOURCES = [
        PointsApiSource::class,
    ];

    private const DEFAULT_STORAGES = [
        PointsCoordinatesStorage::class,
        PointsCollectionStorage::class,
    ];

    public function __construct(MapBoxPointsSaver $mapBoxPointsSaver, MapBoxPointsSearcher $mapBoxPointsSearcher)
    {
        $this->mapBoxPointsSaver = $mapBoxPointsSaver;
        $this->mapBoxPointsSearcher = $mapBoxPointsSearcher;
    }

    public function getOnePoint(string $searchString, $sources = []) : ?MapPoint
    {
        $points = $this->getPointsCollection($searchString, $sources, 1);

        return $points[0] ?? null;
    }

    public function getPointsCollection(
        string $searchString,
        $sources = [],
        int $limit = 5,
        int $offset = 0
    ) : array {
        foreach(array_merge(self::DEFAULT_SOURCES, $sources) as $source){
            $this->mapBoxPointsSearcher->addSource(app()->make($source));
        }

        return $this->mapBoxPointsSearcher->searchPoints($searchString, $limit, $offset);
    }

    public function getPointByCoordinates(string $coordinates) : ?MapPoint
    {
        $this->clear();

        $point = $this->getOnePoint($coordinates);

        if(!$point){
            return null;
        }

        $this->savePoint($point);

        return $point;
    }

    public function getPointByAddress($address) : ?MapPoint
    {
        $this->clear();

        $point = $this->getOnePoint($address, $this->getPointSourcesByAddress());

        if(!$point){
            return null;
        }

        $this->savePoint($point);

        return $point;
    }

    public function getPointsByAddress(string $address, int $limit, int $offset) : array
    {
        $this->clear();

        $points = $this->getPointsCollection($address, $this->getPointSourcesByAddress(), $limit, $offset);

        if(empty($points)){
            return [];
        }

        foreach($points as $point){
            $this->savePoint($point);
        }
    }

    public function getDeparturePointByAddress(string $address) : ?MapPoint
    {
        $this->clear();

        $point = $this->getOnePoint($address, $this->getPointSourcesByAddress());

        if(!$point){
            return null;
        }

        $this->savePoint($point, [
            DeparturePointsStorage::class
        ]);

        return $point;
    }

    public function getDestinationPointByAddress(string $address) : ?MapPoint
    {
        $this->clear();

        $point = $this->getOnePoint($address, $this->getPointSourcesByAddress());

        if(!$point){
            return null;
        }

        $this->savePoint($point, [
            DestinationPointsStorage::class
        ]);

        return $point;
    }

    private function getPointSourcesByAddress() : array
    {
        $sources = [
            PointsStorageHistorySource::class
        ];

        if(MapBoxConfig::isLocationSearchEnabled()){
            $sources[] = PointsByLocationStorageCollectionSource::class;
            $sources[] = PointsByLocationApiSource::class;
        }

        $sources[] = PointsStorageCollectionSource::class;

        return $sources;
    }

    private function clear() : void
    {
        $this->mapBoxPointsSaver->clearStorages();
        $this->mapBoxPointsSearcher->clearSources();
    }

    private function savePoint(MapPoint $point, $storages = []) : void
    {
        foreach(array_merge(self::DEFAULT_STORAGES, $storages) as $storage){
            $this->mapBoxPointsSaver->addStorage(app()->make($storage));
        }

        $this->mapBoxPointsSaver->savePoint($point);
    }

}