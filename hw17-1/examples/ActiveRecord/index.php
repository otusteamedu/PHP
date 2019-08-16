<?php

require_once '../../vendor/autoload.php';

use TimGa\DbPatterns\Database\Postgres;
use TimGa\DbPatterns\Model\ActiveRecord\Schedule;

$pdo = Postgres::connect('pgsql:host=192.168.56.101;dbname=cinema', 'timofey', 'timofey123');

$schedule1 = new Schedule($pdo);
$schedule2 = new Schedule($pdo);
$schedule3 = new Schedule($pdo);

// setup schedules
$schedule1
    ->setMovieId(1)
    ->setBeginTime('2019-08-14 10:00:00')
    ->setHallId(2)
    ->setPrice(150);
$schedule2
    ->setMovieId(1)
    ->setBeginTime('2019-08-14 12:00:00')
    ->setHallId(2)
    ->setPrice(150);
$schedule3
    ->setMovieId(2)
    ->setBeginTime('2019-08-14 12:00:00')
    ->setHallId(1)
    ->setPrice(150);

// insert
$schedule1->insert();
$schedule2->insert();
$schedule3->insert();

// update
$schedule2->setPrice(200);
$schedule2->update();

// business logic (check if both schedules are for the same movieId)
var_dump($schedule1->isTheSameMovie($schedule2));  // true
var_dump($schedule1->isTheSameMovie($schedule3));  // false