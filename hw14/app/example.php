<?php
/**
* This script is a part of the ActiveRecord projects
* Contains some usage examples
*
* @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
*/
require_once "vendor/autoload.php";

/**
* Database connection config
*/
$config = Jekys\Main\Config::getInstance();

$config->db_name = $_SERVER['DB_NAME'];
$config->db_host = $_SERVER['DB_HOST'];
$config->db_user = $_SERVER['DB_USER'];
$config->db_pass = $_SERVER['DB_PASS'];

/**
* Create movie
*/
$newMovie = new Jekys\Movie();
$newMovie->title = 'Test movie';
$newMovie->year = 2014;
$newMovie->save();
$movieId = $newMovie->id;
var_dump($movieId);

/**
* Movie update
*/
$movie = Jekys\Movie::find($movieId);
var_dump($movie->title);
$movie->title = 'Test movie updated';
$movie->save();
var_dump($movie->title);

/**
* Movie delete
*/
$movie = Jekys\Movie::find($movieId);
$movie->delete();
var_dump(Jekys\Movie::find($movieId));

/**
* Find movie
*/
$existedMovie = Jekys\Movie::find(1);
var_dump($existedMovie->title);

/**
* Lazy loaded field
*/
var_dump($existedMovie->rating_id);
