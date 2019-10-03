<?php
declare(strict_types=1);

/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */

namespace APP;

class Dijkstra
{
    private const INFINITE = 10000;
    /**
     * @var $graph Graph
     */
    private $graph;
    private $shortestDistanceToVertex;
    private $isVertexProcessed;
    private $weightMatrix;

    public function __construct(Graph $graph)
    {
        $this->graph = $graph;
        $this->weightMatrix = $this->graph->getWeightMatrix();
    }

    public function process(): void
    {
        $this->initialization();

        do {
            $minWeight = self::INFINITE;
            $minIndex = self::INFINITE;

            for ($i = 1; $i <= $this->graph->getNumberOfVertices(); $i++) {
                if (($this->isVertexProcessed[$i] === false) && ($this->shortestDistanceToVertex[$i] < $minWeight)) {
                    $minWeight = $this->shortestDistanceToVertex[$i];
                    $minIndex = $i;
                }
            }

            if ($minIndex !== self::INFINITE) {
                for ($i = 1; $i <= $this->graph->getNumberOfVertices(); $i++) {
                    if ($this->weightMatrix[$minIndex][$i] > 0) {
                        $temp = $minWeight + $this->weightMatrix[$minIndex][$i];
                        if ($temp < $this->shortestDistanceToVertex[$i]) {
                            $this->shortestDistanceToVertex[$i] = $temp;
                        }
                    }
                }
                $this->isVertexProcessed[$minIndex] = true;
            }

        } while (in_array(false, $this->isVertexProcessed));
    }

    public function getShortestDistanceToVertex(): array
    {
        return $this->shortestDistanceToVertex ?? [];
    }

    private function initialization(): void
    {
        $this->shortestDistanceToVertex = array_fill(
            1,
            $this->graph->getNumberOfVertices(),
            self::INFINITE
        );
        $this->shortestDistanceToVertex[1] = 0;
        $this->isVertexProcessed = array_fill(1, $this->graph->getNumberOfVertices(), false);
    }
}