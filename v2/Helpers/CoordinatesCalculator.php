<?php


namespace v2\Helpers;


class CoordinatesCalculator
{
    public static function getSearchCoordinatesByPointAndRadius($coordinates, $distanceInMeters)
    {
        if(!$coordinates){
            return [];
        }

        $parsedCoordinates = self::parseCoordinates($coordinates);
        $longitude = $parsedCoordinates['longitude'];
        $latitude = $parsedCoordinates['latitude'];

        $latRadian = deg2rad($latitude);

        $degLatKm = 110.574235;
        $degLongKm = 110.572833 * cos($latRadian);
        $deltaLat = $distanceInMeters / 1000.0 / $degLatKm;
        $deltaLong = $distanceInMeters / 1000.0 / $degLongKm;

        $searchCoordinates = [];
        $searchCoordinates['minLat'] = round($latitude - $deltaLat, 6);
        $searchCoordinates['minLong'] = round($longitude - $deltaLong, 6);
        $searchCoordinates['maxLat'] = round($latitude + $deltaLat, 6);
        $searchCoordinates['maxLong'] = round($longitude + $deltaLong, 6);

        return $searchCoordinates;
    }

    public static function getDistanceByCoordinates($coordinatesFrom, $coordinatesTo, $unit = 'K') {

        if(!$coordinatesFrom){
            return 0;
        }

        $parsedCoordinatesFrom = self::parseCoordinates($coordinatesFrom);
        $parsedCoordinatesTo = self::parseCoordinates($coordinatesTo);

        $lon1 = $parsedCoordinatesFrom['longitude'];
        $lon2 = $parsedCoordinatesTo['longitude'];
        $lat1 = $parsedCoordinatesFrom['latitude'];
        $lat2 = $parsedCoordinatesTo['latitude'];

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

    public static function parseCoordinates($coordinates)
    {
        $arrayCoordinates = explode(',', $coordinates);
        return [
            'longitude' => $arrayCoordinates[0],
            'latitude' => $arrayCoordinates[1],
        ];
    }
}