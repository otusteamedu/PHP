<?php

require_once __DIR__ . '/autoload.php';

use App\Models\Film;

//var_dump(Film::findAll());

$film = new Film();

$film->name = "Король лев";
$film->year = 2019;
$film->save();

$film_1 = Film::findById(7);

$film_2 = Film::findById(7);

var_dump($film_1 === $film_2); //true

