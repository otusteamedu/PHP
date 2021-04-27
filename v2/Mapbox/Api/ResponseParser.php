<?php


namespace v2\Mapbox\Api;


use stdClass;
use v2\Mapbox\Entities\MapPoint;

class ResponseParser
{
    public function execute($response) : array
    {
        $points = [];
        $i = 0;
        $point = $this->getRawDataPointByIndex($response, $i);

        while($point instanceof stdClass){
            $points[] = $this->makePointDTO($point);
            $point =  $this->getRawDataPointByIndex($response, $i++);
        }

        return $points;
    }

    private function makePointDTO(stdClass $point) : MapPoint
    {
        $country = '';
        $city = '';
        $region = '';

        $context = $point->context ?? [];

        foreach($context as $item){
            switch($this->getNameContextItem($item)){
                case 'place': $city = $item->text; break;
                case 'region': $region = $item->text; break;
                case 'country': $country = $item->text; break;
            }
        }

        $pointDTO = new MapPoint($point->id);
        $pointDTO->setAddress($point->text . (isset($point->address) ? ', '.$point->address : ''));
        $pointDTO->setLongitude($point->center[0]);
        $pointDTO->setLatitude($point->center[1]);
        $pointDTO->setCity($city);
        $pointDTO->setRegion($region);
        $pointDTO->setCountry($country);

        return  $pointDTO;
    }

    private function getRawDataPointByIndex($response, $index) : ?stdClass
    {
        return $response->features[$index] ?? null;
    }

    private function getNameContextItem($item) : string
    {
        return substr($item->id, 0, strpos($item->id, '.'));
    }
}