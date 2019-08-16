<?php

require_once '../../vendor/autoload.php';

use TimGa\DbPatterns\Database\Postgres;
use TimGa\DbPatterns\Model\RowGateway\Movie;
use TimGa\DbPatterns\Model\RowGateway\MovieFinder;

$pdo = Postgres::connect('pgsql:host=192.168.56.101;dbname=cinema', 'timofey', 'timofey123');

// create new movie
$movie = new Movie($pdo);
$movie->setName('Terminator');
$lastId = $movie->insert();

// edit movie name by lastId
$movieFinder = new MovieFinder($pdo);
$movie = $movieFinder->findById($lastId);
$movie->setName('Terminator2');
$movie->update();
