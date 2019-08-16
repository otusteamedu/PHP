<?php

require_once '../../vendor/autoload.php';

use TimGa\DbPatterns\Database\Postgres;
use TimGa\DbPatterns\Model\IdentityMap\MovieFinder;

$pdo = Postgres::connect('pgsql:host=192.168.56.101;dbname=cinema', 'timofey', 'timofey123');

// find movies by id
$movieFinder = new MovieFinder($pdo);
$movie1 = $movieFinder->find(7);
$movie2 = $movieFinder->find(7);
$movie3 = $movieFinder->find(6);

// checks
var_dump($movie1 === $movie2);  // true
var_dump($movie1 === $movie3);  // false
