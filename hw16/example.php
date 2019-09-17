<?php
/**
 * This script is a part of Dijkstra Algorithm Project
 * Shows some useage examples
 *
 * @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
 */
require_once "vendor/autoload.php";

try {
    $data = json_decode(file_get_contents('graph.json'), true);

    $graph = new Jekys\Graph($data);
    $dijkstra = new Jekys\Dijkstra($graph);
    $startNode = 1;

    $routes = $dijkstra->getAllRoutes($startNode);

    //print route collection
    echo $routes.PHP_EOL;

    //print one route
    echo $dijkstra->getRoute($startNode, 4).PHP_EOL;
    echo PHP_EOL;

    //print each route from collection
    foreach ($routes as $node => $route) {
        echo 'Route from node#'.$startNode.' to node#'.$node.':'.PHP_EOL;
        echo $route.PHP_EOL;
        echo PHP_EOL;
    }
} catch (\Exception $e) {
    echo $e->getMessage().PHP_EOL;
}
