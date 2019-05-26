<?php

require 'vendor/autoload.php';

use Otus\FilmModel as Film;

$conStr = "pgsql:host=localhost;port=5432;dbname=test_db2;user=postgres;password=adminPassword";

$pdo = new PDO($conStr);
$pdo->exec('SET search_path TO test_db');

$film = Film::findById($pdo, 12);
$film2 = Film::findById($pdo, 12);
$film2->duration = 666;
// $film->duration == 666

$film = new Film($pdo);
$film->id = 12;
$film->duration = 12;
$film->genre_id = 3;
$film->save(); //update record

$film = new Film($pdo);
$film->title = 'Some title';
$film->duration = 12;
$film->genre_id = 3;
$film->save(); //insert new record

$film = Film::findAll(); //get all rows from table