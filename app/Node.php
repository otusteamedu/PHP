<?php


namespace nvggit;

class Node
{
    protected $id;
    protected $potential;
    protected $potentialFrom;
    protected $connections = array();
    protected $passed = false;

    /**
     * @param mixed $id
     */
    public function __construct($id) {
        $this->id = $id;
    }

    /**
     * @param Node $node
     * @param integer $distance
     */
    public function connect(Node $node, $distance = 1) {
        $this->connections[$node->getId()] = $distance;
    }

    /**
     * Returns the distance to the node.
     * @return array
     */
    public function getDistance(NodeInterface $node) {
        return $this->connections[$node->getId()];
    }

    /**
     * @return array
     */
    public function getConnections() {
        return $this->connections;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return integer
     */
    public function getPotential() {
        return $this->potential;
    }

    /**
     * @return Node
     */
    public function getPotentialFrom() {
        return $this->potentialFrom;
    }

    /**
     * @return boolean
     */
    public function isPassed() {
        return $this->passed;
    }

    public function markPassed() {
        $this->passed = true;
    }

    /**
     * @param integer $potential
     * @param Node $from
     * @return boolean
     */
    public function setPotential($potential, NodeInterface $from) {
        $potential = ( int ) $potential;
        if (! $this->getPotential() || $potential < $this->getPotential()) {
            $this->potential = $potential;
            $this->potentialFrom = $from;
            return true;
        }
        return false;
    }
}