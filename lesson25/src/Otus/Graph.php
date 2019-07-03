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
     * Get shortest path (recursive.. wrong)
     * @param $from
     * @param $to
     * @return mixed
     * @throws \Exception
     */
    public function getDijkstraRoute($from, $to = null)
    {
        if (!array_key_exists($from, $this->graph) || (isset($to) && !array_key_exists($to, $this->graph))) {
            throw new \Exception('Unknown point "from":' . $from . ' or "to":' . $to);
        }
        $paths = array();
        foreach ($this->graph as $node => $weight) {
            $paths[$node]['weight'] = INF;
            $paths[$node]['path'] = [];
        }
        $paths[$from]['weight'] = 0;
        $this->calculatePotentials($paths, $from);
        $paths = array_replace($this->graph, $paths);
        if (isset($to)) {
            return [$to => $paths[$to]];
        }
        return $paths;
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

    /**
     * Get shortest path
     * @param $from
     * @param $to
     * @return mixed
     * @throws \Exception
     */
    public function getAnotherDijkstraRoute($from, $to = null)
    {
        if (!array_key_exists($from, $this->graph) || (isset($to) && !array_key_exists($to, $this->graph))) {
            throw new \Exception('Unknown point "from":' . $from . ' or "to":' . $to);
        }
        $paths = array();
        $list = array();
        foreach ($this->graph as $node => $weight) {
            $paths[$node]['weight'] = $list[$node] = INF;
            $paths[$node]['path'] = [];
        }
        $paths[$from]['weight'] = $list[$from] = 0;
        while ($list) {
            $min = array_search(min($list), $list);
            $this->calculateAnotherPotentials($paths, $list, $min);
            unset($list[$min]);
        }
        if (isset($to)) {
            return [$to => $paths[$to]];
        }
        return $paths;
    }

    /**
     * Function for calculate potentials
     * @param $path
     * @param $list
     * @param $currentNodeId
     */
    private function calculateAnotherPotentials(&$path, &$list, $currentNodeId)
    {
        foreach ($this->graph[$currentNodeId] as $id => $weight) {
            if(!empty($list[$id]) && $list[$currentNodeId] + $weight < $list[$id]) {
                $list[$id] = $path[$id]['weight'] = $list[$currentNodeId] + $weight;
                $path[$id]['path'] = array_merge($path[$currentNodeId]['path'],[$currentNodeId]);
            }
        }
    }
}