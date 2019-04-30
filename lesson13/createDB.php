#!/usr/bin/env php
<?php

require 'vendor/autoload.php';

use Otus\Connection as Connection;

$connectionData = ['host' => 'localhost', 'port' => 5432, 'user' => 'postgres', 'password' => 'adminPassword', 'database'=>'test_db'];

try {
    $pdo = Connection::get()->connect($connectionData['host'],$connectionData['port'], $connectionData['user'], $connectionData['password']);
    $check_db = $pdo->query("SELECT pg_database.datname FROM pg_database WHERE pg_database.datname like '" . $connectionData['database'] . "'")->rowCount();
    if (!$check_db) {
        $answer = '';
        while (!$answer) {
            echo 'Database ' . $connectionData['database'] .  ' already exists. Drop existing database? [y/n]: ';
            $answer = trim(fgets(STDIN));
            if ($answer === 'y') {
                $dropQuery = $pdo->exec('DROP DATABASE ' . $connectionData['database'] . ';');
                var_dump($dropQuery);
            } elseif ($answer === 'n') {
                echo 'Run script with another DB name' . PHP_EOL;
                exit();
            } else {
                $answer = '';
            }
        }
    }
    echo 'Creating DB' . PHP_EOL;
    $pdo->exec('CREATE DATABASE ' . 'test' . ';');
    $pdo->exec('CREATE SCHEMA test;');
} catch (PDOException $e) {
    echo $e->getMessage();
}