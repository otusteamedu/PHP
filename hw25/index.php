<?php
declare(strict_types=1);

require_once __DIR__ . "/vendor/autoload.php";

use APP\Graph;
use APP\Dijkstra;

$graph = new Graph();
$graph->loadGraphFromJSON("graph.json");
$dijkstra = new Dijkstra($graph);
$dijkstra->process();



foreach ($dijkstra->getShortestDistanceToVertex(true) as $index => $distanceToVertex) {
    echo "For the vertex $index distance is $distanceToVertex" . PHP_EOL;
}
