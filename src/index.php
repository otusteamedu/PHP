#!/usr/bin/php
<?php
require('./../vendor/autoload.php');

use Paa\App\{ DataModel, DijkstraAlgoritm };

$data = new DataModel();
$dijkstra = new DijkstraAlgoritm();

$dijkstra->calcAlgoritm($data->getData(), 1, 3);

