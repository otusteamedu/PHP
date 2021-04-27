<?php

namespace App\Services\Mapbox;

use stdClass;

class MapPointParser
{
    public function all($response)
    {
        if(!$this->validate($response)){
            return [];
        }

        $points = [];
        $i = 0;
        $point = $this->getRawDataPointByIndex($response, $i);
        while($point instanceof stdClass){
            array_push($points, $this->parsePoint($point));
            $point =  $this->getRawDataPointByIndex($response, $i+=1);
        }
        return $points;
    }

    private function parsePoint(stdClass $point)
    {
        $id = $point->id;
        $address = $point->text . (isset($point->address) ? ', '.$point->address : '');
        $longitude = $point->center[0];
        $latitude = $point->center[1];
        $country = null;
        $city = null;
        $region = null;

        $context = $point->context ?? [];

        foreach($context as $item){
            switch($this->getNameContextItem($item)){
                case 'place': $city = $item->text; break;
                case 'region': $region = $item->text; break;
                case 'country': $country = $item->text; break;
            }
        }

        return $parsedPoint = [
            'id' => $id,
            'address' => $address,
            'country' => $country,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'city' => $city,
            'region' => $region,
        ];
    }

    private function getRawDataPointByIndex($response, $index)
    {
        return $response->features[$index] ?? false;
    }

    private function getRawDataPoints($response)
    {
        return $response->features;
    }

    private function validate($response)
    {
       return $response && $response instanceof stdClass && isset($response->features) && count($response->features) > 0;
    }

    private function getNameContextItem($item)
    {
        return substr($item->id, 0, strpos($item->id, '.'));
    }
}