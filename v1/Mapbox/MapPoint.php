<?php

namespace App\Services\Mapbox;

class MapPoint
{
    public $id = 0;
    public $coordinates;
    public $fullAddress;
    public $country;
    public $region;
    public $city;
    public $address;
    public $longitude;
    public $latitude;
    public $recent = false;

    public static function create(array $data)
    {
        $point = new MapPoint();
        $point->id = $data['id'] ?? 0;
        $point->longitude = isset($data['longitude']) ? (float)$data['longitude'] : null;
        $point->latitude = isset($data['latitude']) ? (float)$data['latitude'] : null;
        $point->country = $data['country'] ?? '';
        $point->region = $data['region'] ?? '';
        $point->city = $data['city'] ?? '';
        $point->address = $data['address'] ?? '';
        $point->fullAddress = "{$point->country} {$point->city} {$point->region} {$point->address}";
        $point->coordinates = $point->longitude && $point->latitude ? "{$point->longitude},{$point->latitude}" : null;

        return $point;
    }

    public static function createFromCoordinates($coordinates)
    {
        $parsedCoordinates = explode(',', $coordinates);
        return self::create([
            'longitude' =>  $parsedCoordinates[0],
            'latitude' => $parsedCoordinates[1] ?? null,
        ]);
    }
}