<?php

namespace crazydope\algorithms;

use crazydope\algorithms\model\GraphInterface;
use crazydope\algorithms\model\VertexInterface;

class DijkstraAlgorithm implements DijkstraInterface
{
    /**
     * @var VertexInterface
     */
    protected $start;
    /**
     * @var VertexInterface
     */
    protected $end;
    /**
     * @var GraphInterface
     */
    protected $graph;
    /**
     * @var bool
     */
    protected $counted = false;

    /**
     * @return array
     */
    protected function getShortestPath(): array
    {
        $path = [];
        $vertex = $this->end;
        while ((string)$vertex !== (string)$this->start) {
            $path[] = $vertex;
            $vertex = $vertex->getWeightComeFrom();
        }
        $path[] = $this->start;
        return array_reverse($path);

    }

    protected function getLength(): int
    {
        return $this->end->getWeight();
    }

    protected function calculate(VertexInterface $vertex): array
    {
        $connections = $vertex->getConnections();
        foreach ($connections as $name => $length) {
            $apex = $this->graph->getVertex($name);
            if ($vertex->getWeight() + $length < $apex->getWeight()) {
                $apex->setWeight($vertex->getWeight() + $length, $vertex);
            }
        }
        $vertex->setPassed();
        $sorted = array_flip($connections);
        ksort($sorted);
        return $sorted;
    }

    public function __construct(GraphInterface $graph)
    {
        $this->graph = $graph;
    }

    public function setStartVertex(VertexInterface $vertex): DijkstraInterface
    {
        $vertex->setWeight(0);
        $this->start = $vertex;
        return $this;
    }

    public function setEndVertex(VertexInterface $vertex): DijkstraInterface
    {
        $this->end = $vertex;
        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function solve(): string
    {
        if ($this->start === null || $this->end === null) {
            throw new \Exception('Please specify a starting & ending point');
        }

        $connections = [];
        if (!$this->counted) {
            $connections[] = $this->calculate($this->start);
            do {
                $heels = array_shift($connections);
                foreach ($heels as $heel) {
                    $vertex = $this->graph->getVertex($heel);
                    if (!$vertex->isPassed())
                        $connections[] = $this->calculate($vertex);
                }

            } while ($connections);

            $this->counted = true;
        }
        return implode(' - ', $this->getShortestPath()) . ' Length: ' . $this->getLength();
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function solveAll(): string
    {
        $result = '';
        if ($this->start === null) {
            throw new \Exception('Please specify a starting point');
        }

        foreach ($this->graph->getHeels() as $vertex) {
            if ((string)$vertex === (string)$this->start) {
                continue;
            }
            $this->end = $vertex;
            $result .= 'From: ' . $this->start . ' To: ' . $this->end . ' ' . $this->solve() . PHP_EOL;
        }
        return $result;
    }
}