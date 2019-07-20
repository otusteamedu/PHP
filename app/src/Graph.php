<?php

namespace App;

/**
 * Class Graph
 * @package App
 */
class Graph
{
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

        if (isset($nodes[$node->getNumber()])) {
            $neighbors = array_merge(
                $nodes[$node->getNumber()]->getNeighbors(),
                $node->getNeighbors()
            );
            $node->setNeighbors($neighbors);
        }

        $nodes[$node->getNumber()] = $node;
        $this->setNodes($nodes);

        return $this;
    }

    /**
     * @return string
     */
    public function calc(): string
    {
        $nodes = $this->getNodes();
        $nodes[1]->setLength(0);
        $nodes[1]->setPath([1]);

        for ($i = 1; $i <= count($nodes); $i++) {

            echo 'Node #' . $nodes[$i]->getNumber() . PHP_EOL;

            $neighbors = $nodes[$i]->getNeighbors();

            for ($n = 0; $n < count($neighbors); $n++) {
                echo '  neighbor #' . $nodes[$neighbors[$n]['number']]->getNumber() .
                    ' (length ' . $nodes[$neighbors[$n]['number']]->getLength() . ') - ';

                $length = $nodes[$i]->getLength() + $neighbors[$n]['length'];

                if (!$nodes[$neighbors[$n]['number']]->isVisited()) {
                    if ($length < $nodes[$neighbors[$n]['number']]->getLength()) {
                        $nodes[$neighbors[$n]['number']]->setLength($length);
                        $nodes[$neighbors[$n]['number']]->setPath(
                            array_merge(
                                $nodes[$i]->getPath(),
                                [$neighbors[$n]['number']]
                            )
                        );
                        echo 'set new length ';
                    } else {
                        echo 'save old length ';
                    }
                    echo $nodes[$neighbors[$n]['number']]->getLength() . ', path is ' .
                        implode('-', $nodes[$neighbors[$n]['number']]->getPath()) . PHP_EOL;
                } else {
                    echo 'already visited' . PHP_EOL;
                }
            }

            $nodes[$i]->setNeighbors($neighbors);
            $nodes[$i]->setVisited(true);
            echo PHP_EOL;
        }

        return 'Shortest path is ' . implode('-', $nodes[count($nodes)]->getPath()) .
            ', length is ' . $nodes[count($nodes)]->getLength() . PHP_EOL;
    }

    /**
     * @param array $json
     */
    private function initGraph(array $json): void
    {
        foreach ($json as $edge) {
            $node1 = new Node($edge[0]);
            $node2 = new Node($edge[1]);

            $node1->addNeighbor($node2->getNumber(), $edge[2]);
            $node2->addNeighbor($node1->getNumber(), $edge[2]);

            $this->addNode($node1);
            $this->addNode($node2);
        }
    }
}
