<?php
use PHPUnit\Framework\TestCase;
use Jekys\Route;

/**
* Test for Jekys\Route entity
*
* @coversDefaultClass \Jekys\Route
*
* @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
*/
class RouteTest extends TestCase
{
    /**
     * Test for instance addNode() method
     * When we add a new node, node cost should be added to the route cost
     * If previous route cost was PHP_MAX_INT, cost should be repaced
     *
     * @covers ::addNode()
     *
     * @return void
     */
    public function testAddNode()
    {
        $route = new Route(1, PHP_INT_MAX);
        $this->assertEquals($route->getCost(), PHP_INT_MAX);

        $route->addNode(2, 10);
        $this->assertEquals($route->getCost(), 10);

        $route->addNode(3, 20);
        $this->assertEquals($route->getCost(), 30);

        $route = new Route(1, 1);
        $this->assertEquals($route->getCost(), 1);

        $route->addNode(2, 10);
        $this->assertEquals($route->getCost(), 11);

        $route->addNode(3, 20);
        $this->assertEquals($route->getCost(), 31);
    }

    /**
    * Test for instance getCost() method
    * Method should return summary cost for the current route
    *
    * @covers ::getCost
    *
    * @return void
    */
    public function testGetCost(): void
    {
        $route = new Route(1);
        $this->assertEquals($route->getCost(), 0);

        $route->addNode(2, 5);
        $this->assertEquals($route->getCost(), 5);

        $route->addNode(3, 11);
        $this->assertEquals($route->getCost(), 16);
    }

    /**
    * Test for instance method getRoute() method
    * Method should return array of nodes for the current route
    *
    * @covers ::getRoute
    *
    * @return void
    */
    public function testGetRoute(): void
    {
        $route = new Route(1);
        $this->assertEquals($route->getRoute(), [1]);

        $route->addNode(2, 5);
        $this->assertEquals($route->getRoute(), [1, 2]);

        $route->addNode(3, 11);
        $this->assertEquals($route->getRoute(), [1, 2, 3]);
    }

    /**
    * Test for instance method __toString() method
    * Method should return current node as a string
    *
    * @covers ::__toString
    *
    * @return void
    */
    public function testToString(): void
    {
        $route = new Route(1);
        $this->assertEquals($route->__toString(), '1 (0)');

        $route->addNode(2, 5);
        $this->assertEquals($route->__toString(), '1 -> 2 (5)');

        $route->addNode(3, 11);
        $this->assertEquals($route->__toString(), '1 -> 2 -> 3 (16)');

        $route = new Route(1, PHP_INT_MAX);
        $this->assertEquals($route->__toString(), 'No route');

        $route->addNode(2, 10);
        $this->assertEquals($route->__toString(), '1 -> 2 (10)');
    }
}
