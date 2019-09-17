<?php
use PHPUnit\Framework\TestCase;
use Jekys\Graph;
use Jekys\Exception\InvalidEdgeException;
use Jekys\Exception\EdgeNotFoundException;

/**
* Test for Jekys\Graph entity
*
* @coversDefaultClass \Jekys\Graph
*
* @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
*/
class GraphTest extends TestCase
{
    /**
    * @var array - test data
    */
    private $testGraph = [
        [1, 2, 5],
        [1, 3, 4],
        [2, 1, 5],
        [2, 4, 4],
        [3, 1, 4],
        [3, 4, 6]
    ];

    /**
    * Test for object entity constructor
    * If some edges in graph description are wrong we should get an exception
    *
    * @covers ::__construct
    *
    * @return void
    */
    public function testInvalidEdgeException(): void
    {
        $this->expectException(InvalidEdgeException::class);

        $data = [
            [1, 2, 5],
            [1, 3, 4],
            [2, 4]
        ];

        $graph = new Graph($data);
    }

    /**
    * Test for instace getNodeEdges() method
    * If node wasn't found in getNodeEdges() call we should get an exception
    *
    * @covers ::getNodeEdges
    *
    * @return void
    */
    public function testEdgeNotFoundException(): void
    {
        $this->expectException(EdgeNotFoundException::class);

        $graph = new Graph($this->testGraph);
        $graph->getNodeEdges(5);
    }

    /**
    * Test for instace getNodeEdges() method
    * Method should return array of edges for specified node
    *
    * @covers ::getNodeEdges
    *
    * @return void
    */
    public function testGetNodeEdges(): void
    {
        $graph = new Graph($this->testGraph);

        $this->assertEquals(
            $graph->getNodeEdges(1),
            [
                2 => 5,
                3 => 4
            ]
        );

        $this->assertEquals(
            $graph->getNodeEdges(2),
            [
                1 => 5,
                4 => 4
            ]
        );

        $this->assertEquals(
            $graph->getNodeEdges(3),
            [
                1 => 4,
                4 => 6
            ]
        );
    }

    /**
    * Test for instance getNodes() method
    * Method should return an array of nodes in the graph
    *
    * @covers ::getNodes
    *
    * @return void
    */
    public function testGetNodes()
    {
        $graph = new Graph($this->testGraph);

        $this->assertEquals(
            $graph->getNodes(),
            [1, 2, 3, 4]
        );
    }

    /**
    * Test for instance getNodesCount() method
    * Method should return count of all nodes in the graph
    *
    * @covers ::getNodesCount
    *
    * @return void
    */
    public function testGetNodesCount(): void
    {
        $graph = new Graph($this->testGraph);

        $this->assertEquals($graph->getNodesCount(), 4);
    }
}
