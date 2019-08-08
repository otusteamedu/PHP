<?php

namespace crazydope\algorithms\model;

class Graph implements GraphInterface
{
    protected $heels = [];

    /**
     * @param VertexInterface $apex
     * @return GraphInterface
     */
    public function add(VertexInterface $apex): GraphInterface
    {
        if (in_array((string)$apex, $this->getHeels(), true)) {
            throw new \InvalidArgumentException('The apex is already set.');
        }

        $this->heels[(string)$apex] = $apex;
        return $this;
    }

    /**
     * @param string $name
     * @return VertexInterface|null
     */
    public function getVertex(string $name): ?VertexInterface
    {
        if (!isset($this->heels[$name])) {
            return null;
        }

        return $this->heels[$name];
    }

    public function getHeels(): array
    {
        return  $this->heels;
    }
}