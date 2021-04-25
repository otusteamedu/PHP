<?php


namespace v2\Mapbox\Sources;

use v2\Helpers\CoordinatesCalculator;
use v2\Location\Facades\UserLocation;
use v2\Mapbox\Managers\MapBoxApi;
use v2\Mapbox\MapBoxConfig;

class PointsByLocationApiSource implements PointsSource
{
    private MapBoxApi $apiManager;

    public function __construct(MapBoxApi $apiManager)
    {
        $this->apiManager = $apiManager;
    }

    public function searchByAddress(string $address, int $limit = 5, int $offset = 0): array
    {
        $position = UserLocation::get();

        if($this->isCountryBindSearch() && $position->countryCode){
            $this->apiManager->setCountry($position->countryCode);
        }

        $proximity = "{$position->longitude},{$position->latitude}";

        $poligonCoordinates = CoordinatesCalculator::getSearchCoordinatesByPointAndRadius(
            $proximity,
            MapBoxConfig::getLocationSearchRadius()
        );

        $this->apiManager->setProximity($proximity);
        $this->apiManager->setSearchBox("{$poligonCoordinates['minLong']},{$poligonCoordinates['minLat']},
            {$poligonCoordinates['maxLong']},{$poligonCoordinates['maxLat']}");
        $this->apiManager->setLimit($limit + $offset);

        return array_slice($this->apiManager->getPoints($address), $offset, $limit);
    }
}