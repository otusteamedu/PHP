<?php

require_once '../vendor/autoload.php';

use Alex\Deikstra\Graf;

//json file with data
$filePath = __DIR__ . '/input.json';

//create graf instance
$graf = new Graf($filePath);

$fromNode = '1';
$toNode = '6';

//calc path
$path = $graf->getPath($fromNode, $toNode);

//get distances
$distances = $graf->getDistances($fromNode);

//output result
echo $path . '<br/>' . $distances;
