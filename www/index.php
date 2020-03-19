<?php
include_once 'vendor/autoload.php';
$graph = new \Tirei01\Hw15\Graph(9);
$graph->setLink(1, 2, 10);
$graph->setLink(1, 4, 8);
$graph->setLink(1, 3, 6);


$graph->setLink(2, 7, 11);
$graph->setLink(2, 4, 5);
$graph->setLink(2, 5, 13);

$graph->setLink(3, 5, 3);

$graph->setLink(4, 7, 12);
$graph->setLink(4, 6, 7);
$graph->setLink(4, 5, 5);
$graph->setLink(4, 3, 2);

$graph->setLink(5, 6, 9);
$graph->setLink(5, 9, 12);

$graph->setLink(6, 8, 8);
$graph->setLink(6, 9, 10);

$graph->setLink(7, 6, 4);
$graph->setLink(7, 8, 6);
$graph->setLink(7, 9, 16);

$graph->setLink(8, 9, 15);

$find = new \Tirei01\Hw15\Dijkstra(1, 9, $graph);
$arVertex = $find->find();
$arTmpVer = array();
/** @var \Tirei01\Hw15\Vertex $vertex */
foreach ($arVertex as $vertex) {
    $arTmpVer[] = $vertex->getNumber();
}
echo implode('->', $arTmpVer);

/*
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



$iteration = new \Tirei01\Hw15\Dijkstra\Iteration(1, 9, $graph);
$iteration->find();
*/