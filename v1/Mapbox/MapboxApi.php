<?php

namespace App\Services\Mapbox;
use App\Services\Helpers\CoordinatesCalculator;
use App\Services\Storage\PointHistoryStorage;
use App\Services\Storage\PointsStorage;
use Ixudra\Curl\Facades\Curl;
use Services\Location\Facades\UserLocation;
use Stevebauman\Location\Position;

class MapboxApi
{
    public $limit = 1;

    public function getPointByAddress(string $address)
    {
        return $this->getPointsByAddress($address, 1);
    }

    public function getPointsByAddress(string $address, $limit = 5)
    {
        $this->setLimit($limit);
        $text = implode(',', (explode(' ',$address)));

        //search points by user history
        $points = $this->getPointsByHistory($address);

        //search points by storage and location
        if(count($points) < $limit && $this->isLocationSearchEnabled()){
            $points = array_unique(array_merge($points, $this->getPointsByStorageAndLocation($address)), SORT_REGULAR);
        }

        //search points by location
        if(count($points) < $limit && $this->isLocationSearchEnabled()){
            $points = array_unique(array_merge($points, $this->getPointsByLocation($this->getUrl($text))), SORT_REGULAR);
        }

        //search points by storage
        if(count($points) < $limit){
            $points = array_unique(array_merge($points, $this->getPointsByStorage($address)), SORT_REGULAR);
        }

        //search points by all world
        if(count($points) < $limit){
            $points = array_unique(array_merge($points, $this->getPointsByDefaultData($this->getUrl($text))), SORT_REGULAR);
        }

        return array_slice(collect($points)->unique('coordinates')->toArray(), 0, $this->limit);
    }

    public function getPointByCoordinates(string $coordinates)
    {
        $this->setLimit(1);
        $points = $this->getPointsByDefaultData($this->getUrl($coordinates));

        return  $points[0] ?? false;
    }

    protected function getPointsByHistory(string $address)
    {
        $points = PointHistoryStorage::getHistoryPoints();

        return array_filter($points, function($point) use ($address){
            return stripos($point->fullAddress, $address);
        });
    }

    protected function getPointsByStorageAndLocation(string $address)
    {
        $points = PointsStorage::get(PointsStorage::KEY) ?: [];

        $position = UserLocation::get();
        $poligonCoordinates = $this->getPolygonCoordinatesByPosition($position);

        $country = null;
        if($this->isCountryBindSearch() && $position->countryName){
            $country = $position->countryName;
        }

        return array_filter($points, function($point) use ($address, $poligonCoordinates, $country){
             if($point->longitude >= $poligonCoordinates['minLong']
                 && $point->longitude <= $poligonCoordinates['maxLong']
                 && $point->latitude >= $poligonCoordinates['minLat']
                 && $point->latitude <= $poligonCoordinates['maxLat']
                 && stripos($point->fullAddress, $address)
                 && (is_null($country) || $country && $point->country)
             )
             {
                return true;
             }
        });
    }

    protected function getPointsByStorage(string $address)
    {
        $points = PointsStorage::get(PointsStorage::KEY) ?: [];

        return array_filter($points, function($point) use ($address){
            return stripos($point->fullAddress, $address);
        });
    }

    protected function getUrl(string $textSearch)
    {
        return config('services.mapbox.url_geocoding').'/'.urlencode($textSearch).".json";
    }

    protected function getPoints($response)
    {
        $pointsData = resolve(MapPointParser::class)->all($response);

        if(!empty($pointsData)){
            $mapPoints = [];
            while($pointsData){
                $point = array_shift($pointsData);
                $mapPoint = MapPoint::create($point);
                PointsStorage::savePoint($mapPoint);
                array_push($mapPoints,$mapPoint);
            }
            return $mapPoints;
        }

        return [];
    }

    protected function getPointsByLocation($url)
    {
        $response = $this->sendPointsRequestByLocation($url);

        return $this->getPoints($response);
    }

    protected function getPointsByDefaultData($url)
    {
        $response = $this->sendPointsRequest($url, $this->getDefaultRequestData());

        return $this->getPoints($response);
    }

    protected function sendPointsRequest($url, $data)
    {
        $response = Curl::to($url)
            ->withData($data)
            ->asJson()
            ->get();

        return $response;
    }

    protected function sendPointsRequestByLocation($url)
    {
        $data = $this->getDefaultRequestData();

        $position = UserLocation::get();
        $data['proximity'] = "{$position->longitude},{$position->latitude}";
        $poligonCoordinates = $this->getPolygonCoordinatesByPosition($position);
        $data['bbox'] = "{$poligonCoordinates['minLong']},{$poligonCoordinates['minLat']},{$poligonCoordinates['maxLong']},{$poligonCoordinates['maxLat']}";

        if($this->isCountryBindSearch() && $position->countryCode){
            $data['country'] = $position->countryCode;
        }

        return $this->sendPointsRequest($url, $data);
    }

    protected function isLocationSearchEnabled()
    {
        return config('services.mapbox.location.enabled') === true;
    }

    protected function isCountryBindSearch()
    {
        return $this->isLocationSearchEnabled() && config('services.mapbox.location.country_bind') === true;
    }

    protected function getPolygonCoordinatesByPosition(Position $position)
    {
        $coordinates = "{$position->longitude},{$position->latitude}";
        $radius = config('services.mapbox.location.search_radius');
        return CoordinatesCalculator::getSearchCoordinatesByPointAndRadius($coordinates, $radius);
    }

    protected function getDefaultRequestData()
    {
        return  [
            'access_token' => config('services.mapbox.mapbox_access_token'),
            'limit' => $this->limit,
            'types' => config('services.mapbox.data_types'),
            'language' => app()->getLocale(),
        ];
    }

    protected function setLimit($value)
    {
        $this->limit = $value;
    }
}