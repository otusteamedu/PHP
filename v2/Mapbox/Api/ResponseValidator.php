<?php


namespace v2\Mapbox\Api;


use stdClass;

class ResponseValidator
{
    public function execute($response) : bool
    {
        return $response &&
            $response instanceof stdClass &&
            isset($response->features) &&
            count($response->features) > 0;
    }
}