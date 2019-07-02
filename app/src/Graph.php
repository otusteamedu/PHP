<?php

namespace App;

use InvalidArgumentException;

/**
 * Class Graph
 * @package App
 */
class Graph
{
    private const INFINITY = 999;

    /**
     * @var array
     */
    private $nodes;

    /**
     * Graph constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->setNodes([]);
        $json = json_decode(file_get_contents($path), true);
        $this->initGraph($json);
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return $this->nodes;
    }

    /**
     * @param mixed $nodes
     */
    public function setNodes(array $nodes): self
    {
        $this->nodes = $nodes;

        return $this;
    }

    /**
     * @param Node $node
     * @return Graph
     */
    public function addNode(Node $node): self
    {
        $nodes = $this->getNodes();
        $nodes[] = $node;
        $this->setNodes($nodes);

        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        if (!$node = $this->getFirstNode()) {
            throw new InvalidArgumentException('Can not find node #1');
        }

        do {
            $nearestNode = $this->lookingForNeighbors($node);
            echo 'Take node #' . $node->getNumber() . PHP_EOL;
            $node = $nearestNode;
        } while ($node !== null);

        return '';
    }

    /**
     * @param Node $node
     * @return Node|null
     */
    private function lookingForNeighbors(Node $node): ?Node
    {
        $length = self::INFINITY;
        $nearestNode = null;

        /**
         * @var Node $neighborNode
         */
        foreach ($node->getNeighbors() as $neighbor) {
            $neighborNode = $neighbor['node'];

            if (!$neighborNode->isVisited()) {
                if ($neighborNode->getLength() > $neighbor['length']) {
                    $neighborNode->setLength($neighbor['length']);
                }

                if ($neighbor['length'] < $length) {
                    $nearestNode = $neighborNode;
                    $length = $neighbor['length'];
                }
            }
        }

        $node->setVisited(true);

        return $nearestNode;
    }

    /**
     * @param array $json
     */
    private function initGraph(array $json): void
    {
        foreach ($json as $edge) {
            $node1 = new Node($edge[0]);
            $node2 = new Node($edge[2]);
            $node1->addNeighbor($node2, $edge[1]);
            $node2->addNeighbor($node1, $edge[1]);
            $this->addNode($node1);
            $this->addNode($node2);
        }
    }

    /**
     * @return Node|null
     */
    private function getFirstNode(): ?Node
    {
        foreach ($this->getNodes() as $node) {
            if ($node->getNumber() === 1) {
                return $node;
            }
        }

        return null;
    }
}
