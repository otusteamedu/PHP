#!/usr/bin/env php
<?php

require 'vendor/autoload.php';

use Otus\Connection as Connection;
use Otus\Creator as Creator;

$connectionData = ['host' => 'localhost', 'port' => 5432, 'user' => 'postgres', 'password' => 'adminPassword', 'database' => 'test_db2', 'schema' => 'test_db'];
//todo чтение параметров
$options = getopt("hvs", ['help', 'host', 'port', 'user', 'password', 'database', 'schema']);
if (array_key_exists('h', $options) || array_key_exists('help', $options)) {
    echo "Options:\n'--host' - host(default: localhost),\n"
        . "'--port' - port(default: 5432),\n"
        . "'--user' - user(default: postgres),\n"
        . "'--password' - password(default: adminPassword),\n"
        . "'--database' - database(default: test_db),\n"
        . "'--schema' - schema(default: test_db),\n"
        . "'-v' - verbose mode,\n"
        . "'-s' - silence mode,\n"
        . "'-h\\--help' - this message." . PHP_EOL;
    exit();
}

try {
    // Check DB
    $pdo = Connection::get()->connect($connectionData['host'], $connectionData['port'], $connectionData['user'], $connectionData['password']);
    $creator = new Creator($pdo, $connectionData);

//    die(var_dump($creator->checkDb()));
    $checkDb = $creator->checkDb();
    if (!$checkDb) {
        $answer = '';
        while (!$answer) {
            echo 'Database ' . $connectionData['database'] . ' not exists. Create database? [y/n]: ';
            $answer = trim(fgets(STDIN));
            if ($answer === 'y') {
                echo 'Creating DB' . PHP_EOL;
                $creator->createDb();
            } elseif ($answer === 'n') {
                echo 'Run script with another DB name' . PHP_EOL;
                exit();
            } else {
                $answer = '';
            }
        }
    }
    // change connection to chosen db
    $pdo = Connection::get()->connect($connectionData['host'], $connectionData['port'], $connectionData['user'], $connectionData['password'], $connectionData['database']);
    $creator->setPdo($pdo);

    // check schema
    $checkSchema = $creator->checkSchema();

    if ($checkSchema) {
        $answer = '';
        while (!$answer) {
            echo 'Schema ' . $connectionData['schema'] . ' exists. Drop existing schema? [y/n]: ';
            $answer = trim(fgets(STDIN));
            if ($answer === 'y') {
                echo 'Dropping schema ' . $connectionData['schema'] . PHP_EOL;
                $creator->dropSchema();
            } elseif ($answer === 'n') {
                echo 'Run script with another schema name' . PHP_EOL;
                exit();
            } else {
                $answer = '';
            }
        }
    }
    echo 'Creating schema' . PHP_EOL;
    $creator->createSchema();
    echo 'Creating tables' . PHP_EOL;
    $creator->createDefaultTables();
} catch (PDOException $e) {
    echo $e->getMessage();
}