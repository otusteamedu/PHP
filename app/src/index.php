<?php

namespace App;

include_once __DIR__ . '/../vendor/autoload.php';

$graph = new Graph('/app/src/dijkstra.json');
echo $graph->calc();
