<?php

namespace v2\Mapbox\Api;

use v2\Mapbox\MapBoxConfig;

class Client
{
    private string $searchString = '';
    private array $requestData;

    private const DEFAULT_LIMIT = 1;

    public function __construct()
    {
        $this->requestData = [
            'access_token' => MapBoxConfig::getAccessToken(),
            'limit' => self::DEFAULT_LIMIT,
            'types' => MapBoxConfig::getDataTypes(),
            'language' => app()->getLocale(),
        ];
    }

    /**
     * @return mixed
     */
    public function send()
    {
        return Curl::to($this->getUrl())
            ->withData($this->getRequestData())
            ->asJson()
            ->get();
    }

    public function setSearchString(string $searchString) : void
    {
        $this->searchString = $searchString;
    }

    public function getUrl() : string
    {
        return MapBoxConfig::getUrlGeocoding().'/'.urlencode($this->searchString).".json";
    }

    public function getRequestData() : array
    {
        return $this->requestData;
    }

    public function setLimit(int $value) : void
    {
        $this->set('limit', $value);
    }

    public function setProximity(string $value) : void
    {
        $this->set('proximity', $value);
    }

    public function setSearchBox(string $value) : void
    {
        $this->set('bbox', $value);
    }

    public function setCountry(string $value) : void
    {
        $this->set('country', $value);
    }

    /**
     * @param string $param
     * @param mixed $value
     */
    public function set(string $param, $value) : void
    {
        $this->requestData[$param] = $value;
    }
}