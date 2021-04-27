<?php

namespace v2\Mapbox\Managers;

use v2\Mapbox\Api\Client;
use v2\Mapbox\Api\ResponseParser;
use v2\Mapbox\Api\ResponseValidator;

final class MapBoxApi
{
    private Client $client;
    private ResponseParser $responseParser;
    private ResponseValidator $responseValidator;

    public function __construct()
    {
        $this->client = new Client();
        $this->responseParser = new ResponseParser();
        $this->responseValidator = new ResponseValidator();
    }

    public function setLimit(int $value) : void
    {
        $this->client->setLimit($value);
    }

    public function setProximity(string $value) : void
    {
        $this->client->setProximity($value);
    }

    public function setSearchBox(string $value) : void
    {
        $this->client->setSearchBox($value);
    }

    public function setCountry(string $value) : void
    {
        $this->client->setCountry($value);
    }

    public function getPoints(string $searchString) : array
    {
        $this->client->setSearchString($searchString);
        $response = $this->client->send();

        if(false === $this->responseValidator->execute($response)){
            return [];
        }

        return $this->responseParser->execute($response);
    }
}