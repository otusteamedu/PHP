<?php


namespace v2\Services\MapBox\Storages;


use v2\Mapbox\Entities\MapPoint;

interface PointsStorage
{
    public function save(MapPoint $point): void;
    public function getById(int $id): ?MapPoint;
    public function getAll(): array;
}