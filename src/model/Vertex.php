<?php

namespace crazydope\algorithms\model;

class Vertex implements VertexInterface
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var int
     */
    protected $weight = 999;
    /**
     * @var array
     */
    protected $connections = [];
    /**
     * @var bool
     */
    protected $passed = false;
    /**
     * @var VertexInterface;
     */
    protected $from;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @param VertexInterface $apex
     * @param int $length
     * @return VertexInterface
     */
    public function addConnection(VertexInterface $apex, int $length = 1): VertexInterface
    {
        $this->connections[(string)$apex] = $length;
        return $this;
    }

    /**
     * @param string $apex
     * @return int
     */
    public function getConnection(string $apex): ?int
    {
        if (!isset($this->connections[$apex])) {
            return null;
        }
        return $this->connections[$apex];
    }

    /**
     * @return array
     */
    public function getConnections(): array
    {
        return $this->connections;
    }

    /**
     * @return bool
     */
    public function isPassed(): bool
    {
        return $this->passed;
    }

    /**
     * @return VertexInterface
     */
    public function setPassed(): VertexInterface
    {
        $this->passed = true;
        return $this;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     * @param VertexInterface|null $vertex
     * @return VertexInterface
     */
    public function setWeight(int $weight, ?VertexInterface $vertex = null): VertexInterface
    {
        if (!$this->weight || $weight < $this->weight) {
            $this->weight = $weight;
            $this->from = $vertex;
        }
        return $this;
    }

    public function getWeightComeFrom(): ?VertexInterface
    {
        return $this->from;
    }
}