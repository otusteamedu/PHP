<?php


namespace v2\Mapbox\Managers;

use v2\Mapbox\Sources\PointsSource;

class MapBoxPointsSearcher
{
    /**
     * @var array|PointsSource[]
     */
    private array $sources = [];

    public function addSource(PointsSource $pointsSource) : void
    {
        $this->sources[] = $pointsSource;
    }

    public function clearSources() : void
    {
        $this->sources = [];
    }

    public function searchPoints(string $searchString, int $limit, int $offset = 0) : array
    {
        $results = [];
        foreach($this->sources as $source){
            $points = $source->searchByAddress($searchString, $limit, $offset);
            $results[] = $points;

            if(count($points) > $limit){
                break;
            }
        }

        return array_unique(array_merge([], ...$results));
    }
}