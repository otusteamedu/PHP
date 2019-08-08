<?php

namespace crazydope\algorithms;

use crazydope\algorithms\model\VertexInterface;

interface DijkstraInterface
{
    public function setStartVertex(VertexInterface $vertex): DijkstraInterface;

    public function setEndVertex(VertexInterface $vertex): DijkstraInterface;

    public function solve(): string;

    public function solveAll(): string;
}