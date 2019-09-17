<?php
namespace Jekys;

use Jekys\Exception\EdgeNotFoundException;
use Jekys\Exception\NodeNotFoundException;

/**
 * Realization of Dijkstra algorithm
 *
 * @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
 */
class Dijkstra
{
    /**
    * @var Jekys\Graph;
    */
    protected $graph;

    /**
    * @var array - already calculated routes for nodes
    */
    protected $calculated = [];

    /**
    * class entity constructor
    *
    * @param Jekys\Graph $graph
    *
    * @return void
    */
    public function __construct(Graph $graph)
    {
        $this->graph = $graph;
    }

    /**
     * Calculates all routes from specified node
     *
     * @param string $from
     *
     * @return void
     */
    private function calcRoutes(string $from): void
    {
        $routes = new RouteCollection();

        foreach ($this->graph->getNodes() as $node) {
            $cost = ($node == $from) ? 0 : PHP_INT_MAX;
            $routes[$node] = new Route($from, $cost);
        }

        $currentNode = $from;
        $checkedNodes = [];

        while (count($checkedNodes) != $this->graph->getNodesCount()) {
            try {
                $nextNodes = $this->graph->getNodeEdges($currentNode);
            } catch (EdgeNotFoundException $e) {
                $nextNodes = [];
            }

            foreach ($nextNodes as $nextNode => $cost) {
                if ($routes[$currentNode]->getCost() + $cost < $routes[$nextNode]->getCost()) {
                    $routes[$nextNode] = clone $routes[$currentNode];
                    $routes[$nextNode]->addNode($nextNode, $cost);
                }
            }

            $checkedNodes[] = $currentNode;
            $currentNode = current(
                array_diff($this->graph->getNodes(), $checkedNodes)
            );
        }

        $this->calculated[$from] = $routes;
    }

    /**
     * Returns collection of optimal routes from specified node
     *
     * @param string $from
     *
     * @return Jekys\RouteCollection
     */
    public function getAllRoutes(string $from): RouteCollection
    {
        if (!array_key_exists($from, $this->calculated)) {
            $this->calcRoutes($from);
        }

        return $this->calculated[$from];
    }

    /**
     * Returns optimal route from one node to another
     *
     * @param string $from
     * @param string $to
     *
     * @throws Jekys\Exception\NodeNotFoundException
     *
     * @return Jekys\Route
     */
    public function getRoute(string $from, string $to): Route
    {
        if (!in_array($from, $this->graph->getNodes())) {
            throw new NodeNotFoundException('Invalid from node');
        }

        if (!in_array($to, $this->graph->getNodes())) {
            throw new NodeNotFoundException('Invalid to node');
        }

        $routes = $this->getAllRoutes($from);

        return $routes[$to];
    }
}
