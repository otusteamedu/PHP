#!/usr/bin/env php
<?php

require '../vendor/autoload.php';

use Otus\Graph;

$routes = file_get_contents('Dijkstra.json');
try {
    $from = 1;
    $to = 11;
    $graph = Graph::getGraphByRoutes(json_decode($routes));
    $result = $graph->getAnotherDijkstraRoute($from, $to);
    // Shortest path from '1' to '11' is: 1->2->5->6->9->10->11. It cost: 38
    foreach ($result as $toKey => $data) {
        if ($data['weight'] !== INF) {
            echo "Shortest path from '$from' to '$toKey' is: " . implode('->', array_merge($data['path'], [$toKey])) . '. It cost: ' . $data['weight'] . PHP_EOL;
        } else {
            echo "Path from '$from' to '$toKey' is unreachable. . It cost: " . $data['weight'] . PHP_EOL;
        }
    }
    echo PHP_EOL;
    $result = $graph->getAnotherDijkstraRoute($from);
//    Shortest path from '1' to '1' is: 1. It cost: 0
//    Shortest path from '1' to '2' is: 1->2. It cost: 4
//    Shortest path from '1' to '3' is: 1->2->3. It cost: 19
//    Shortest path from '1' to '6' is: 1->2->5->6. It cost: 18
//    Shortest path from '1' to '4' is: 1->4. It cost: 17
//    Shortest path from '1' to '5' is: 1->2->5. It cost: 10
//    Shortest path from '1' to '7' is: 1->4->7. It cost: 21
//    Shortest path from '1' to '9' is: 1->2->5->6->9. It cost: 27
//    Shortest path from '1' to '8' is: 1->4->7->8. It cost: 27
//    Shortest path from '1' to '10' is: 1->2->5->6->9->10. It cost: 31
//    Shortest path from '1' to '11' is: 1->2->5->6->9->10->11. It cost: 38
//    Shortest path from '1' to '12' is: 1->2->5->6->9->10->12. It cost: 33
//    Path from '1' to '13' is unreachable. . It cost: INF
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
    $result = $graph->getAnotherDijkstraRoute($from);
//    Shortest path from '1' to '1' is: 1. It cost: 0
//    Shortest path from '1' to '2' is: 1->2. It cost: 4
//    Shortest path from '1' to '3' is: 1->2->3. It cost: 19
//    Shortest path from '1' to '6' is: 1->2->5->6. It cost: 18
//    Shortest path from '1' to '4' is: 1->4. It cost: 17
//    Shortest path from '1' to '5' is: 1->2->5. It cost: 10
//    Shortest path from '1' to '7' is: 1->4->7. It cost: 21
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





