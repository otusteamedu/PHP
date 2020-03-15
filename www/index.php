<?php
include_once 'vendor/autoload.php';

$graph = new \Tirei01\Hw15\Dijkstra\Graph();
$v = new \Tirei01\Hw15\Dijkstra\Vertex(1, 2, 10, $graph);
$v = new \Tirei01\Hw15\Dijkstra\Vertex(1, 4, 8, $graph);
$v = new \Tirei01\Hw15\Dijkstra\Vertex(1, 3, 6, $graph);

$v = new \Tirei01\Hw15\Dijkstra\Vertex(2, 7, 11, $graph);
$v = new \Tirei01\Hw15\Dijkstra\Vertex(2, 4, 5, $graph);
$v = new \Tirei01\Hw15\Dijkstra\Vertex(2, 5, 13, $graph);

$v = new \Tirei01\Hw15\Dijkstra\Vertex(3, 5, 3, $graph);

$v = new \Tirei01\Hw15\Dijkstra\Vertex(4, 7, 12, $graph);
$v = new \Tirei01\Hw15\Dijkstra\Vertex(4, 6, 7, $graph);
$v = new \Tirei01\Hw15\Dijkstra\Vertex(4, 5, 5, $graph);
$v = new \Tirei01\Hw15\Dijkstra\Vertex(4, 3, 2, $graph);

$v = new \Tirei01\Hw15\Dijkstra\Vertex(5, 6, 9, $graph);
$v = new \Tirei01\Hw15\Dijkstra\Vertex(5, 9, 12, $graph);

$v = new \Tirei01\Hw15\Dijkstra\Vertex(6, 8, 8, $graph);
$v = new \Tirei01\Hw15\Dijkstra\Vertex(6, 9, 10, $graph);

$v = new \Tirei01\Hw15\Dijkstra\Vertex(7, 6, 4, $graph);
$v = new \Tirei01\Hw15\Dijkstra\Vertex(7, 8, 6, $graph);
$v = new \Tirei01\Hw15\Dijkstra\Vertex(7, 9, 16, $graph);

$v = new \Tirei01\Hw15\Dijkstra\Vertex(8, 9, 15, $graph);


// TODO DEL THIS
echo "<pre style='color:red; clear: both;'>";
var_dump($graph->getVertexList());
echo "</pre>";
$iteration = new \Tirei01\Hw15\Dijkstra\Iteration(1, 9, $graph);
$iteration->find();
// TODO DEL THIS
//echo "<pre style='color:red; clear: both;'>";
//print_r($iteration);
//echo "</pre>";