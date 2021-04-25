<?php

namespace v2\Mapbox;

class MapBoxConfig
{
    public static function isLocationSearchEnabled() : bool
    {
        return config('services.mapbox.location.enabled') === true;
    }

    public static function isCountryBindSearch() : bool
    {
        return self::isLocationSearchEnabled() && config('services.mapbox.location.country_bind') === true;
    }

    public static function getLocationSearchRadius() : int
    {
        return config('services.mapbox.location.search_radius');
    }

    public static function getAccessToken() : string
    {
        return config('services.mapbox.mapbox_access_token');
    }

    public static function getDataTypes() : array
    {
        return config('services.mapbox.data_types');
    }

    public static function getUrlGeocoding() : string
    {
        return config('services.mapbox.url_geocoding');
    }
}