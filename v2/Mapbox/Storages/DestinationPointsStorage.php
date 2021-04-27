<?php


namespace v2\Services\MapBox\Storages;

use Illuminate\Support\Facades\Auth;

class DestinationPointsStorage extends PointsCollectionStorage
{
    protected function getKey() : string
    {
        return 'destination_points' . Auth::id();
    }
}