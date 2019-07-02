<?php

namespace App;

/**
 * Class Node
 * @package App
 */
class Node
{
    private const INFINITY = 999;

    /**
     * @var int
     */
    private $number;

    /**
     * @var bool
     */
    private $visited;

    /**
     * @var int
     */
    private $length;

    /**
     * @var array
     */
    private $path;

    /**
     * @var array
     */
    private $neighbors;

    /**
     * Node constructor.
     * @param int $number
     */
    public function __construct(int $number)
    {
        $this->setNumber($number);
        $this->setVisited(false);
        $this->setLength(self::INFINITY);
        $this->setPath([]);
        $this->setNeighbors([]);
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @param int $number
     * @return Node
     */
    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return bool
     */
    public function isVisited(): bool
    {
        return $this->visited;
    }

    /**
     * @param bool $visited
     * @return Node
     */
    public function setVisited(bool $visited): self
    {
        $this->visited = $visited;

        return $this;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @param int $length
     * @return Node
     */
    public function setLength(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    /**
     * @return array
     */
    public function getPath(): array
    {
        return $this->path;
    }

    /**
     * @param array $path
     * @return Node
     */
    public function setPath(array $path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return array
     */
    public function getNeighbors(): array
    {
        return $this->neighbors;
    }

    /**
     * @param array $neighbors
     * @return Node
     */
    public function setNeighbors(array $neighbors): self
    {
        $this->neighbors = $neighbors;

        return $this;
    }

    /**
     * @param Node $node
     * @return Node
     */
    public function addNeighbor(Node $node, int $length): self
    {
        $neighbors = $this->getNeighbors();
        $neighbors[] = [
            'node' => $node,
            'length' => $length
        ];
        $this->setNeighbors($neighbors);

        return $this;
    }
}
