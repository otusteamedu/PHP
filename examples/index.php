<?php

require '../vendor/autoload.php';

$builder = new \crazydope\algorithms\GraphBuilder(new \crazydope\algorithms\model\Graph());
$graph = $builder->build(\json_decode(file_get_contents('data.json'),true));
$algorithm = new \crazydope\algorithms\DijkstraAlgorithm($graph);
$algorithm->setStartVertex($graph->getVertex(1));
echo $algorithm->solveAll();