<?php

require_once '../../vendor/autoload.php';

use TimGa\DbPatterns\Database\Postgres;
use TimGa\DbPatterns\Model\LazyLoad\Movie;

$pdo = Postgres::connect('pgsql:host=192.168.56.101;dbname=cinema', 'timofey', 'timofey123');

// get movie data (get only movie name from DB, without schedule data)
$movie = Movie::getMovieById($pdo, 7);
var_dump($movie->scheduleCollection);  // schedule data is NULL

// add scheduleCollection to movie object
$scheduleCollection = $movie->getScheduleCollection();
var_dump($movie->scheduleCollection); // schedule data presented
