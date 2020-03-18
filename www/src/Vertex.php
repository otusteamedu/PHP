<?php

namespace Tirei01\Hw15;
class Vertex
{
    private int $number;
    private array $links;

    public function __construct(int $number)
    {
        $this->number = $number;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setLink(Vertex $vertex, $weight): void
    {
        $this->links[] = new VertexLink($vertex, $weight);
    }

    public function getLink(){
        return $this->links;
    }
}