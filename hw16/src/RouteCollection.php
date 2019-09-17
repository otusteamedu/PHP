<?php
namespace Jekys;

/**
* Class for RouteCollection entity
*
* @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
*/
class RouteCollection extends \ArrayObject
{
    /**
    * Sets a new route to the collection
    *
    * @param mixed $index
    * @param mixed $newval
    *
    * @throws Exception
    *
    * @return void
    */
    public function offsetSet($index, $newval): void
    {
        if (!$newval instanceof Route) {
            throw new \Exception('value must be an instance of Jekys\Route');
        }

        parent::offsetSet($index, $newval);
    }

    /**
    * Returns collection of routes as a string
    *
    * @return string
    */
    public function __toString(): string
    {
        $result = '';
        $this->ksort();

        foreach ($this as $node => $route) {
            $result .= $node.': '.$route->__toString().PHP_EOL;
        }

        return $result;
    }
}
