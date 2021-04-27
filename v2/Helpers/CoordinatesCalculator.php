<?php


namespace v2\Helpers;

use v2\Helpers\DataTransferObjects\GeoPoint;
use v2\Helpers\DataTransferObjects\GeoRectangle;

class CoordinatesCalculator
{
    private const KM_IN_ONE_DEGREE_OF_LATITUDE = 110.574235;
    private const KM_IN_ONE_DEGREE_OF_LONGITUDE_BY_EKVATOR = 110.572833;
    private const METERS_IN_KM = 1000;
    private const ROUND_PRECISION = 6;
    private const MINUTES_IN_DEGREE = 60;
    private const STATUTE_MILES_IN_NAUTICAL_MILES = 1.1515;

    public function getSearchCoordinatesByPointAndRadius(GeoPoint $geoPoint, int $distanceInMeters) : GeoRectangle
    {
        $latRadian = deg2rad($geoPoint->getLatitude());

        $degLatKm = self::KM_IN_ONE_DEGREE_OF_LATITUDE;
        $degLongKm = self::KM_IN_ONE_DEGREE_OF_LONGITUDE_BY_EKVATOR * cos($latRadian);
        $deltaLat = $distanceInMeters / self::METERS_IN_KM / $degLatKm;
        $deltaLong = $distanceInMeters / self::METERS_IN_KM / $degLongKm;

        return new GeoRectangle(
            round($geoPoint->getLongitude() - $deltaLong, self::ROUND_PRECISION),
            round($geoPoint->getLatitude() - $deltaLat, self::ROUND_PRECISION),
            round($geoPoint->getLongitude() + $deltaLong, self::ROUND_PRECISION),
            round($geoPoint->getLatitude() + $deltaLong, self::ROUND_PRECISION)
        );
    }

    public function getDistanceByCoordinates(GeoPoint $geoPointFrom, GeoPoint $geoPointTo, string $unit = DistanceUnits::KM) : float
    {
        $theta = $geoPointFrom->getLongitude() - $geoPointTo->getLongitude();
        $dist = sin(deg2rad($geoPointFrom->getLatitude())) * sin(deg2rad($geoPointTo->getLatitude())) +
            cos(deg2rad($geoPointFrom->getLatitude())) * cos(deg2rad($geoPointTo->getLatitude())) * cos(deg2rad($theta));

        $miles = rad2deg(acos($dist)) * self::MINUTES_IN_DEGREE * self::STATUTE_MILES_IN_NAUTICAL_MILES;

        return app('DistanceUnits')->convert($miles, $unit);
    }
}