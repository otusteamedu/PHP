<?php

namespace crazydope\algorithms\model;

interface GraphInterface
{
    public function add(VertexInterface $apex): GraphInterface;

    public function getVertex(string $name): ?VertexInterface;

    public function getHeels(): array;
}