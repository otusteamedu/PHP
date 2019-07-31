<?php

use nvggit\Graph;
use nvggit\Node;
use nvggit\Dijkstra;

function printShortestPath($from_name, $to_name, $routes)
{
    $graph = new Graph();
    foreach ($routes as $route) {
        $from = $route['from'];
        $to = $route['to'];
        $price = $route['weight'];
        if (!array_key_exists($from, $graph->getNodes())) {
            $from_node = new Node($from);
            $graph->add($from_node);
        } else {
            $from_node = $graph->getNode($from);
        }
        if (!array_key_exists($to, $graph->getNodes())) {
            $to_node = new Node($to);
            $graph->add($to_node);
        } else {
            $to_node = $graph->getNode($to);
        }
        $from_node->connect($to_node, $price);
    }

    $g = new Dijkstra($graph);
    $start_node = $graph->getNode($from_name);
    $end_node = $graph->getNode($to_name);
    $g->setStartingNode($start_node);
    $g->setEndingNode($end_node);

    echo "From: " . $start_node->getId() . "\n";
    echo "To: " . $end_node->getId() . "\n";
    echo "Route: " . $g->getLiteralShortestPath() . "\n";
    echo "Total: " . $g->getDistance() . "\n";
}

$routes = array();
$routes[] = array('from' => 'a', 'to' => 'b', 'weight' => 2);
$routes[] = array('from' => 'c', 'to' => 'd', 'weight' => 4);
$routes[] = array('from' => 'b', 'to' => 'c', 'weight' => 1);
$routes[] = array('from' => 'a', 'to' => 'd', 'weight' => 9);
$routes[] = array('from' => 'b', 'to' => 'd', 'weight' => 8);

printShortestPath('a', 'd', $routes);