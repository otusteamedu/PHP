<?php

namespace crazydope\algorithms\model;

interface VertexInterface
{
    public function __construct(string $name);

    public function __toString();

    public function addConnection(VertexInterface $apex, int $length = 1): VertexInterface;

    public function getConnections(): array;

    public function getConnection(string $apex): ?int;

    public function isPassed(): bool;

    public function setPassed(): VertexInterface;

    public function setWeight(int $weight,?VertexInterface $vertex = null): VertexInterface;

    public function getWeight(): int;

    public function getWeightComeFrom(): ?VertexInterface;

}