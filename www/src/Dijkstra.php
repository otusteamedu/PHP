<?php

namespace Tirei01\Hw15;

class Dijkstra
{
    private int $start;
    private int $finish;
    private Graph $graph;
    private array $search;
    private DijkstraElement $current;
    private array $optimalPath;

    public function __construct($start, $finish, Graph $graph)
    {
        $this->start = $start;
        $this->finish = $finish;
        $this->graph = $graph;
        $this->search = array();
    }

    private function add(DijkstraElement $vertex)
    {
        $isset = false;
        /** @var DijkstraElement $search */
        foreach ($this->search as $search) {
            if ($search->getVertex()->getNumber() === $vertex->getVertex()->getNumber()) {
                if ($search->isFinish() === false) {
                    $backElemDj = $this->getDijkstraByVertex($vertex->getBackVertex());
                    if ($search->getLengthPath() > ($vertex->getLengthPath() + $backElemDj->getLengthPath())) {
                        $search->setLengthPath($vertex->getLengthPath());
                        $search->setBackVertex($vertex->getBackVertex());
                    }
                }
                $isset = true;
            }
        }
        if ($isset === false) {
            if ($vertex->getBackVertex() !== null) {
                $backElemDj = $this->getDijkstraByVertex($vertex->getBackVertex());
                $vertex->setLengthPath($backElemDj->getLengthPath() + $vertex->getLengthPath());
            }
            $this->search[] = $vertex;
        }
    }

    private function getDijkstraByVertex(Vertex $vertex): DijkstraElement
    {
        /** @var DijkstraElement $search */
        foreach ($this->search as $search) {
            if ($search->getVertex()->getNumber() === $vertex->getNumber()) {
                return $search;
            }
        }
    }

    private function findOptimalPath()
    {
        /** @var DijkstraElement $smallElem */
        $smallElem = null;
        /** @var DijkstraElement $search */
        foreach ($this->search as $search) {
            if ($search->isFinish() === true) {
                continue;
            }
            if ($smallElem === null) {
                $smallElem = $search;
            } elseif ($smallElem->getLengthPath() > $search->getLengthPath()) {
                $smallElem = $search;
            }
        }
        if ($smallElem !== null) {
            $smallElem->setFinish();
            $this->current = $smallElem;
        }
    }

    private function start()
    {
        $startVertex = $this->graph->getVertexByNum($this->start);
        $this->current = new DijkstraElement($startVertex, true, 0, null);
        $this->add($this->current);
    }

    private function check()
    {
        $backElemDj = $this->getDijkstraByVertex($this->current->getVertex());
        return !($this->finish === $this->current->getVertex()->getNumber() && $backElemDj->isFinish());
    }

    public function find(): array
    {
        $this->start();
        while ($this->check()) {
            $arVertexLink = $this->current->getVertex()->getLink();
            /** @var VertexLink $vartexLink */
            foreach ($arVertexLink as $vartexLink) {
                $tmpDijElem = new DijkstraElement(
                    $vartexLink->getVertex(), false, $vartexLink->getWeigth(), $this->current->getVertex()
                );
                $this->add($tmpDijElem);
            }
            $this->findOptimalPath();
        }
        return $this->getOptimalPath();
    }

    private function getOptimalPath()
    {
        $this->optimalPath[] = $this->current->getVertex();
        while ($backPath = $this->current->getBackVertex()) {
            $this->optimalPath[] = $backPath;
            $this->current = $this->getDijkstraByVertex($backPath);
        }
        return array_reverse($this->optimalPath);
    }
}