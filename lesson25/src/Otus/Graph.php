<?php

namespace Otus;


/**
 * Class Graph
 * @package Otus
 */
class Graph
{
    /**
     * @var array
     */
    protected $graph;

    /**
     * Graph constructor.
     * @param array $graph
     */
    public function __construct(array $graph)
    {
        $this->graph = $graph;
    }

    /**
     * setting up graph by routes
     * @param $routes
     * @return Graph
     * @throws \Exception
     */
    public static function getGraphByRoutes($routes)
    {
        $graph = array();
        foreach ($routes as $route) {
            if (count($route) != 3) {
                throw new \Exception('Route must have 3 values "from", "to", "weight');
            }
            $graph[$route[0]][$route[1]] = $route[2];
            //We can have nodes without routes from
            if (!array_key_exists($route[1], $graph)) {
                $graph[$route[1]] = array();
            }
        }
        return new self($graph);
    }

    /**
     * Get shortest path
     * @param $from
     * @param $to
     * @return mixed
     * @throws \Exception
     */
    public function getDijkstraRoute($from, $to)
    {
        if (!array_key_exists($from, $this->graph) || !array_key_exists($from, $this->graph)) {
            throw new \Exception('Unknown point "from":' . $from . ' or "to":' . $to);
        }
        $paths = array();
        foreach ($this->graph as $node => $weight) {
            $paths[$node]['weight'] = INF;
            $paths[$node]['path'] = [];
            $paths[$node]['isChecked'] = false;
        }
        $paths[$from]['weight'] = 0;
        $this->calculatePotentials($paths, $from);
        if (count($paths[$to]) < 1) {
            throw new \Exception("No route from '$from' to '$to' ");
        }
        $paths[$to]['path'] = array_merge($paths[$to]['path'], [$to]);
        return $paths[$to];
    }

    /**
     * Recursive function for calculate potentials
     * @param $path
     * @param $currentNodeId
     */
    private function calculatePotentials(&$path, $currentNodeId)
    {
        foreach ($this->graph[$currentNodeId] as $id => $weight) {
            $currentWeight = $path[$currentNodeId]['weight'] + $weight;
            if ($path[$id]['weight'] > $currentWeight && !in_array($id, $path[$currentNodeId]['path'])) {
                $path[$id]['weight'] = $currentWeight;
                $path[$id]['path'] = array_merge($path[$currentNodeId]['path'], [$currentNodeId]);
                $path[$id]['isChecked'] = false;
            }
        }
        $path[$currentNodeId]['isChecked'] = true;
        foreach ($this->graph[$currentNodeId] as $id => $weight) {
            if (!$path[$id]['isChecked'] && !in_array($id, $path[$currentNodeId]['path'])) {
                $this->calculatePotentials($path, $id);
            }
        }
    }
}