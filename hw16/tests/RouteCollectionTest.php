<?php
use PHPUnit\Framework\TestCase;
use Jekys\Route;
use Jekys\RouteCollection;

/**
* Test for Jekys\RouteCollection entity
*
* @coversDefaultClass \Jekys\RouteCollection
* @uses \Jekys\Route
*
* @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
*
*/
class RouteCollectionTest extends TestCase
{
    /**
    * Test for instance offsetSet method()
    * If value not an instance of Jekys\Route we should get an exception
    *
    * @covers ::offsetSet
    *
    * @return void
    */
    public function testOffsetSetException(): void
    {
        $this->expectException(\Exception::class);

        $routes = new RouteCollection();
        $route = '1 -> 2 (5)';

        $routes[] = $route;
    }

    /**
    * Test for instance offsetSet and offsetGet() methods
    * Checks a possibility to set and get routes in the object via array methods
    *
    * @covers ::offsetSet
    * @covers ::offsetGet
    *
    * @return void
    */
    public function testOffsetSet(): void
    {
        $routes = new RouteCollection();

        $route1 = new Route('1');
        $routes[] = $route1;
        $this->assertEquals($routes[0], $route1);

        $route2 = new Route('1');
        $routes[] = $route2;
        $this->assertEquals($routes[1], $route2);

        $route3 = new Route('1');
        $routes[1] = $route3;
        $this->assertEquals($routes[1], $route3);
    }

    /**
    * Test for instance offsetUnset and offsetExists() methods
    * Checks a possibility to unset and routes in the object via array methods
    *
    * @covers ::offsetExists
    *
    * @return void
    */
    public function testOffsetUnset(): void
    {
        $routes = new RouteCollection();

        $routes[] = new Route('1');
        $routes[] = new Route('1');

        $this->assertTrue(isset($routes[1]));

        unset($routes[1]);

        $this->assertFalse(isset($routes[1]));
    }

    /**
    * Test for instance Iterator methods
    * Checks a possibility to work with with object like with array
    *
    * @return void
    */
    public function testIterator(): void
    {
        $routes = new RouteCollection();

        $route1 = new Route('1');
        $route1->addNode(2, 5);
        $route1->addNode(3, 4);

        $routes[] = $route1;

        $route2 = new Route('1');
        $route2->addNode(2, 6);

        $routes[] = $route2;

        $this->assertEquals(current($routes), $route1);
        $this->assertEquals(next($routes), $route2);
        $this->assertEquals(reset($routes), $route1);
        $this->assertEquals(end($routes), $route2);
        $this->assertEquals(prev($routes), $route1);

        $results = [
            '1 -> 2 -> 3 (9)',
            '1 -> 2 (6)'
        ];

        foreach ($routes as $key => $route) {
            $this->assertEquals($route->__toString(), $results[$key]);
        }
    }

    /**
    * Test instance __toString() method
    * Method should return all collection as a string
    *
    * @covers ::__toString
    *
    * @return void
    */
    public function testToStrig()
    {
        $routes = new RouteCollection();

        $route1 = new Route('1');
        $route1->addNode(2, 5);
        $route1->addNode(3, 4);

        $routes[1] = $route1;

        $route2 = new Route('1');
        $route2->addNode(2, 6);

        $routes[2] = $route2;

        $this->assertEquals(
            $routes->__toString(),
            '1: 1 -> 2 -> 3 (9)'.PHP_EOL.'2: 1 -> 2 (6)'.PHP_EOL
        );
    }
}
