<?php

namespace Tirei01\Hw15;

class VertexLink
{
    private Vertex $vertex;
    private int $weight;
    public function __construct(Vertex $vertex, $weight)
    {
        $this->vertex = $vertex;
        $this->weight = $weight;
    }

    /**
     * @return Vertex
     */
    public function getVertex(): Vertex
    {
        return $this->vertex;
    }

    public function getWeigth(){
        return $this->weight;
    }

}