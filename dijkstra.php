<?php

$weights = [
    ['1', '2', 1],
    ['2', '3', 2],
    ['1', '3', 5],
];

$points = [
    '1' => ['distanceToPoint' => PHP_INT_MAX, 'isVisited' => false],
    '2' => ['distanceToPoint' => PHP_INT_MAX, 'isVisited' => false],
    '3' => ['distanceToPoint' => PHP_INT_MAX, 'isVisited' => false],
];

function getPointWithNewLength($newLength, string $pointName, array $points) {
    $point = $points[$pointName];
    $point['distanceToPoint'] = $newLength;

    return $point;
}

function getDistanceBetweenNeighbors(string $from, string $to, $weights) {
    foreach($weights as $weight) {
        if(($weight[0] === $from && $weight[1] === $to)
        || ($weight[1] === $from && $weight[0] === $to)) {

            return $weight[2];
        }
    }

    return false;
}

function doDijkstra(string $from, string $to, array $points, array $weights) {
    $isAllPointsVisited = false;
    while(!$isAllPointsVisited) {
        $isAllPointsVisited = true;
        foreach($points as $point) {
            if(!$point['isVisited']) {
                $isAllPointsVisited = false;

            }
        }
    }
}