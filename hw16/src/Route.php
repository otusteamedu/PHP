<?php
namespace Jekys;

/**
* Class describes Route entity
*
* @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
*/
class Route
{
    /**
    * @var array
    */
    private $route = [];

    /**
    * @var int
    */
    private $cost = 0;

    /**
    * Entity object constructor
    *
    * @param string $startNode
    * @param int $cost
    *
    * @return void
    */
    public function __construct(string $startNode, int $cost = 0)
    {
        $this->route[] = $startNode;
        $this->cost = $cost;
    }

    /**
    * Add note to the route
    *
    * @param string $node
    * @param int $cost
    *
    * @return void
    */
    public function addNode(string $node, int $cost): void
    {
        $this->route[] = $node;

        if ($this->cost === PHP_INT_MAX) {
            $this->cost = $cost;
        } else {
            $this->cost += $cost;
        }
    }

    /**
    * Returns summary route cost
    *
    * @return int
    */
    public function getCost(): int
    {
        return $this->cost;
    }

    /**
    * Returns all nodes in the route
    *
    * @return array
    */
    public function getRoute(): array
    {
        return $this->route;
    }

    /**
    * Returns route as a string
    *
    * @return string
    */
    public function __toString(): string
    {
        $result = '';

        if ($this->cost == PHP_INT_MAX) {
            $result .= 'No route';
        } else {
            $result .= implode(' -> ', $this->route);
            $result .= ' ('.$this->cost.')';
        }

        return $result;
    }
}
