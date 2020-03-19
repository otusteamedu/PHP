<?php

namespace Tirei01\Hw15;
class Graph
{
    private array $vertex;

    public function __construct(int $counVertex)
    {
        if ($counVertex > 0) {
            for ($i = 0; $i < $counVertex; $i++) {
                $this->vertex[] = new Vertex(($i + 1));
            }
        }
    }

    /**
     * @param int $from
     * @param int $to
     * @param int $weight
     */
    public function setLink(int $from, int $to, int $weight): void
    {
        $this->getVertexByNum($from)->setLink($this->getVertexByNum($to), $weight);
    }

    /**
     * @return \Generator
     */
    private function vertexList()
    {
        foreach ($this->vertex as $vertex) {
            yield $vertex;
        }
    }

    /**
     * @param int $number
     *
     * @return Vertex|null
     */
    public function getVertexByNum(int $number): ?Vertex
    {
        /** @var Vertex $vertex */
        foreach ($this->vertexList() as $vertex) {
            if ($vertex->getNumber() === $number) {
                return $vertex;
            }
        }
        return null;
    }

    public function getVertexNumbers()
    {
        $arNumbers = array();
        /** @var Vertex $vertex */
        foreach ($this->vertexList() as $vertex) {
            $arNumbers[] = $vertex->getNumber();
        }
        return $arNumbers;
    }
}