<?php

require 'vendor/autoload.php';
use Otus\FilmModel as Film;

$connectionData = ['host' => 'localhost', 'port' => 5432, 'user' => 'postgres', 'password' => 'adminPassword', 'database' => 'test_db2', 'schema' => 'test_db'];
$conStr = sprintf("pgsql:host=%s;port=%d;%suser=%s;password=%s",
    $connectionData['host'],
    $connectionData['port'],
    $connectionData['database'] ? "dbname=" . $connectionData['database'] . ";" : '',
    $connectionData['user'],
    $connectionData['password']);
$pdo = new PDO($conStr);
$pdo->exec('SET search_path TO ' . $connectionData['schema']);

$film = new Film($pdo);
$film->id = 12;
$film->duration =12;
$film->genre_id = 3;
die(var_dump($film->save()));