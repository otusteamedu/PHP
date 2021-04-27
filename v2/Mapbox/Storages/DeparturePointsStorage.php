<?php


namespace v2\Services\MapBox\Storages;


use Illuminate\Support\Facades\Auth;

class DeparturePointsStorage extends PointsCollectionStorage
{
    protected function getKey() : string
    {
        return 'departure_points' . Auth::id();
    }
}