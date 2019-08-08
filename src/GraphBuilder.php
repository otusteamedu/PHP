<?php

namespace crazydope\algorithms;

use crazydope\algorithms\model\GraphInterface;
use crazydope\algorithms\model\Vertex;

class GraphBuilder
{
    /**
     * @var GraphInterface
     */
    protected $graph;
    /**
     * @param string $vertexName
     * @param string $connectionName
     * @param int $length
     */
    protected function add(string $vertexName, string $connectionName, int $length): void
    {
        if($this->graph->getVertex($vertexName) && $this->graph->getVertex($vertexName)->getConnection($connectionName)) {
            return;
        }

        $connection = new Vertex($connectionName);
        if($this->graph->getVertex($vertexName) && !$this->graph->getVertex($vertexName)->getConnection($connectionName)) {
            $this->graph->getVertex($vertexName)->addConnection($connection,$length);
            $this->add($connectionName, $vertexName, $length);
            return;
        }

        $apex = new Vertex($vertexName);
        $apex->addConnection($connection,$length);
        $this->graph->add($apex);
        $this->add($connectionName, $vertexName, $length);
    }

    public function __construct(GraphInterface $graph)
    {
        $this->graph = $graph;
    }

    public function build(array $data): GraphInterface
    {
        foreach ($data as $row){
            [$name,$connection,$dist] = $row;
            $this->add($name,$connection,$dist);
        }

        return $this->graph;
    }
}