<?php

namespace nvggit;

class Graph
{
    /**
     * @var array
     */
    protected $nodes = array();

    /**
     * @param Node $node
     * @return Graph
     * @throws Exception
     */
    public function add(Node $node)
    {
        if (array_key_exists($node->getId(), $this->getNodes())) {
            throw new Exception('Unable to insert multiple Nodes with the same id');
        }
        $this->nodes[$node->getId()] = $node;
        return $this;
    }

    /**
     * @param mixed $id
     * @return Node
     * @throws Exception
     */
    public function getNode($id)
    {
        $nodes = $this->getNodes();
        if (!array_key_exists($id, $nodes)) {
            throw new Exception("Unable to find {$id}");
        }
        return $nodes[$id];
    }

    /**
     * @return array
     */
    public function getNodes()
    {
        return $this->nodes;
    }
}