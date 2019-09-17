<?php
namespace Jekys;

use Jekys\Exception\InvalidEdgeException;
use Jekys\Exception\EdgeNotFoundException;

/**
* Class desccribes Graph entity
*
* @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
*/
class Graph
{
    /**
    * @var array - Graph description with nodes and edges for every node
    */
    private $graph = [];

    /**
    * @var array
    */
    private $nodes = [];

    /**
    * @var int
    */
    private $nodesCount = 0;

    /**
    * class entity constuctor
    *
    * @param array $data
    *
    * @throws Jekys\Exception\InvalidEdgeException
    *
    * @return void
    */
    public function __construct(array $data)
    {
        foreach ($data as $key => $edge) {
            if (count($edge) != 3) {
                throw new InvalidEdgeException('Line: '.$key.'. Not enough elements for edge decription');
            } else {
                $this->addEdge(
                    $edge[0],
                    $edge[1],
                    $edge[2]
                );
            }
        }

        $this->nodesCount = count($this->nodes);
    }

    /**
    * Add edge to the graph
    *
    * @param string $from
    * @param string $to
    * @param int $cost
    *
    * @return void
    */
    private function addEdge(string $from, string $to, int $cost): void
    {
        $this->graph[$from][$to] = $cost;

        $this->nodes = array_unique(
            array_merge(
                $this->nodes,
                [$from, $to]
            )
        );
    }

    /**
    * Returns all edges for specified node
    *
    * @param string $node
    *
    * @throws Jekys\Exception\EdgeNotFoundException
    *
    * @return array
    */
    public function getNodeEdges(string $node): array
    {
        if (!array_key_exists($node, $this->graph)) {
            throw new EdgeNotFoundException('Node: '.$node.' not found in the graph');
        }

        return $this->graph[$node];
    }

    /**
    * Returns list of all grpah nodes
    *
    * @return array
    */
    public function getNodes(): array
    {
        return $this->nodes;
    }

    /**
    * Returns count of nodes in the graph
    *
    * @return int
    */
    public function getNodesCount(): int
    {
        return $this->nodesCount;
    }
}
