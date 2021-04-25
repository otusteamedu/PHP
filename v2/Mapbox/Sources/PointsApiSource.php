<?php


namespace v2\Mapbox\Sources;

use v2\Mapbox\Managers\MapBoxApi;

class PointsApiSource implements PointsSource
{
    private MapBoxApi $apiManager;

    public function __construct(MapBoxApi $apiManager)
    {
        $this->apiManager = $apiManager;
    }

    public function searchByAddress(string $address, int $limit = 5, int $offset = 0): array
    {
        $this->apiManager->setLimit($limit + $offset);

        return array_slice($this->apiManager->getPoints($address), $offset, $limit);
    }
}