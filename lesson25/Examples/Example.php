#!/usr/bin/env php
<?php

require '../vendor/autoload.php';

use Otus\Graph;

$routes = file_get_contents('Dijkstra.json');
try {
    $from = 1;
    $to = 11;
    $graph = Graph::getGraphByRoutes(json_decode($routes));
    $result = $graph->getDijkstraRoute($from, $to);
    // Shortest path from '1' to '11' is: 1->2->5->6->9->10->11. It cost: 38
    foreach ($result as $toKey => $data) {
        if ($data['weight'] !== INF) {
            echo "Shortest path from '$from' to '$toKey' is: " . implode('->', array_merge($data['path'], [$toKey])) . '. It cost: ' . $data['weight'] . PHP_EOL;
        } else {
            echo "Path from '$from' to '$toKey' is unreachable. . It cost: " . $data['weight'] . PHP_EOL;
        }
    }
    echo PHP_EOL;

    $graph = new Graph($arrayGraph = [
        1 => [2 => 4, 4 => 17],
        2 => [3 => 15, 5 => 6],
        3 => [6 => 1, 5 => 10],
        6 => [],
        4 => [5 => 6, 6 => 12, 7 => 4],
        5 => [6 => 8],
        7 => []]);
    $from = 1;
    $to = 7;
    $result = $graph->getDijkstraRoute($from, $to);
    // Shortest path from '1' to '7' is: 1->4->7. It cost: 21
    foreach ($result as $toKey => $data) {
        if ($data['weight'] === INF) {
            echo "Path from '$from' to '$toKey' is unreachable. . It cost: " . $data['weight'] . PHP_EOL;
        } else {
            echo "Shortest path from '$from' to '$toKey' is: " . implode('->', array_merge($data['path'], [$toKey])) . '. It cost: ' . $data['weight'] . PHP_EOL;
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}





