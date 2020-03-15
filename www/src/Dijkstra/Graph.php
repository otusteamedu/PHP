<?php

namespace Tirei01\Hw15\Dijkstra;

class Graph
{
    private array $vertex;
    private array $vertexNumber;
    private array $vertexByFrom;

    public function __construct()
    {
        $this->vertexNumber = array();
    }

    public function addVertex(Vertex $vertex){
        //$this->vertex[] = $vertex;
        $this->vertexByFrom[$vertex->getForm()][] = $vertex;
        $this->vertexNumber[] = $vertex->getForm();
        $this->vertexNumber[] = $vertex->getTo();
    }
    public function getVertexList(){
        $this->vertexNumber = array_unique($this->vertexNumber);
        sort($this->vertexNumber);
        return $this->vertexNumber;
    }

    public function getVertexById(int $id){
        return $this->vertexByFrom[$id];
    }

}