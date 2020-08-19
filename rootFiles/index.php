<?php

require "vendor/autoload.php";


use Controllers\DataBaseControllers\PostgresConnection;
use Models\Movies\Movie;
use Models\Movies\MovieMapper;


try {
    $postgresConnection = new PostgresConnection();
    $pdo = new \PDO($postgresConnection->connectionString());
} catch (\PDOException $e) {
    echo $e->getMessage();
}



$movie = new Movie(
    10020074,
    'Аватар новый',
    '2014-08-12',
    '',
    '/images/avatar',
    'Классный фильм и оскар за лучшие эффекты',
    '2:04',
    14
);

$stmtMovie = new MovieMapper($pdo);
print_r($stmtMovie->getRangeMoviesByCreationDate('2000-01-01', '2020-01-01'));





