<?php

namespace v2\Mapbox\Sources;

interface PointsSource
{
    public function searchByAddress(string $address, int $limit = 5, int $offset = 0) : array;
}