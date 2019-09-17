<?php
use PHPUnit\Framework\TestCase;
use Jekys\Graph;
use Jekys\Dijkstra;
use Jekys\Exception\NodeNotFoundException;

/**
* Test for Jekys\Dijkstra class
*
* @coversDefaultClass \Jekys\Dijkstra
* @uses \Jekys\Graph
*
* @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
*
*/
class DijkstraTest extends TestCase
{
    /**
    * @var array - test graphs
    */
    private $graphs = [
        [
            [1, 2, 5],
            [1, 3, 4],
        ],
        [
            [1, 2, 5],
            [1, 3, 4],
            [2, 1, 5],
            [2, 4, 4],
            [3, 1, 4],
            [3, 4, 6]
        ],
        [
            "0" => [1, 2, 7],
            "1" => [1, 3, 9],
            "2" => [1, 6, 14],
            "3" => [2, 1, 7],
            "4" => [2, 3, 10],
            "5" => [2, 4, 15],
            "6" => [3, 6, 2],
            "7" => [3, 1, 9],
            "8" => [3, 2, 10],
            "9" => [3, 4, 11],
            "10" => [4, 5, 6],
            "11" => [4, 3, 11],
            "12" => [4, 2, 15],
            "13" => [5, 4, 6],
            "14" => [5, 6, 9],
            "15" => [6, 3, 2],
            "16" => [6, 5, 9],
            "17" => [6, 1, 14]
        ]
    ];

    /**
    * Tests for method getAllRoutes()
    * Method should return a collection of routes
    *
    * @covers ::getAllRoutes
    * @return void
    */
    public function testGetAllRoutes(): void
    {
        $results = [
            "1: 1 (0)".PHP_EOL."2: 1 -> 2 (5)".PHP_EOL."3: 1 -> 3 (4)".PHP_EOL,
            "1: 1 (0)".PHP_EOL."2: 1 -> 2 (5)".PHP_EOL."3: 1 -> 3 (4)".PHP_EOL."4: 1 -> 2 -> 4 (9)".PHP_EOL,
            "1: 1 (0)".PHP_EOL."2: 1 -> 2 (7)".PHP_EOL."3: 1 -> 3 (9)".PHP_EOL."4: 1 -> 3 -> 4 (20)".PHP_EOL."5: 1 -> 3 -> 6 -> 5 (20)".PHP_EOL."6: 1 -> 3 -> 6 (11)".PHP_EOL
        ];

        foreach ($this->graphs as $key => $graphData) {
            $graph = new Graph($graphData);
            $dijkstra = new Dijkstra($graph);

            $this->assertEquals(
                $dijkstra->getAllRoutes(1)->__toString(),
                $results[$key]
            );
        }
    }

    /**
    * Tests for instance getRoute() method
    * If we trying to get route from unknown node we should get an Exception
    *
    * @covers ::getRoute
    *
    * @return void
    */
    public function testFromNodeNotFoundException(): void
    {
        $this->expectException(NodeNotFoundException::class);

        $graph = new Graph($this->graphs[0]);
        $dijkstra = new Dijkstra($graph);

        $dijkstra->getRoute(4, 1);
    }

    /**
    * Tests for instance getRoute() method
    * If we trying to get route to unknown node we should get an Exception
    *
    * @covers ::getRoute
    *
    * @return void
    */
    public function testToNodeNotFoundException(): void
    {
        $this->expectException(NodeNotFoundException::class);

        $graph = new Graph($this->graphs[0]);
        $dijkstra = new Dijkstra($graph);

        $dijkstra->getRoute(1, 5);
    }

    /**
    * Tests for method getRoute()
    * Method should return a Route object
    *
    * @covers ::getRoute
    *
    * @return void
    */
    public function testGetRoute(): void
    {
        $results = [
            [
                [
                    'from' => 1,
                    'to' => 2,
                    'result' => '1 -> 2 (5)'
                ],
                [
                    'from' => 1,
                    'to' => 3,
                    'result' => '1 -> 3 (4)'
                ],
            ],
            [
                [
                    'from' => 1,
                    'to' => 2,
                    'result' => '1 -> 2 (5)'
                ],
                [
                    'from' => 1,
                    'to' => 4,
                    'result' => '1 -> 2 -> 4 (9)'
                ],
            ]
        ];

        foreach ($results as $id => $routes) {
            $graph = new Graph($this->graphs[$id]);
            $dijkstra = new Dijkstra($graph);

            foreach ($routes as $route) {
                $this->assertEquals(
                    $dijkstra->getRoute($route['from'], $route['to']),
                    $route['result']
                );
            }
        }
    }
}
