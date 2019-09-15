<?php
// get data from jsonfile
$links = json_decode(file_get_contents('data.json'), true);

// my representation on graph
foreach ($links as $link) {
    $graphRepresentationArray[$link[0]][$link[1]] = $link[2];
    ksort($graphRepresentationArray);
}

// start condition
$routeWeight[1] = 0;
$routeNodes[1] = "1";

// Dijkstra algorithm
foreach ($graphRepresentationArray as $nodeA => $nodesB) {
    foreach ($nodesB as $nodeB => $linkWeight) {
        
        if (!isset($routeWeight[$nodeB]) || ($routeWeight[$nodeB] > ($routeWeight[$nodeA] + $linkWeight))) {
            $routeWeight[$nodeB] = $routeWeight[$nodeA] + $linkWeight;
            $routeNodes[$nodeB] = $routeNodes[$nodeA] ." > ". $nodeB;
        }
    }
}

print_r($routeWeight);
print_r($routeNodes);
