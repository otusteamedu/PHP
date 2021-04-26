<?php


namespace v2\Mapbox\Sources;


use v2\Helpers\CoordinatesCalculator;
use v2\Helpers\DataTransferObjects\GeoPoint;
use v2\Location\Facades\UserLocation;
use v2\Mapbox\Entities\MapPoint;
use v2\Mapbox\MapBoxConfig;
use v2\Services\MapBox\Storages\PointsCollectionStorage;
use v2\Services\MapBox\Storages\PointsStorage;
use Stevebauman\Location\Position;

class PointsByLocationStorageCollectionSource implements PointsSource
{
    private PointsStorage $storage;

    public function __construct(PointsCollectionStorage $storage)
    {
        $this->storage = $storage;
    }

    public function searchByAddress(string $address, int $limit = 5, int $offset = 0): array
    {
        $position = UserLocation::get();
        $country = null;

        if(MapBoxConfig::isCountryBindSearch() && $position->countryName){
            $country = $position->countryName;
        }

        $poligonCoordinates = CoordinatesCalculator::getSearchCoordinatesByPointAndRadius(
            new GeoPoint($position->longitude,$position->latitude),
            MapBoxConfig::getLocationSearchRadius()
        );

        $points = $this->storage->getAll();

        $filteredPoints = array_filter($points, function(MapPoint $point) use ($address, $poligonCoordinates, $country){
            return $point->getLongitude() >= $poligonCoordinates['minLong'] &&
                $point->getLongitude() <= $poligonCoordinates['maxLong'] &&
                $point->getLatitude() >= $poligonCoordinates['minLat'] &&
                $point->getLatitude() <= $poligonCoordinates['maxLat'] &&
                stripos($point->getFullAddress(), $address) &&
                (is_null($country) || ($country && $point->getCountry()));
        });

        return array_slice($filteredPoints, $offset, $limit);
    }
}