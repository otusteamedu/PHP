#!/usr/bin/env php
<?php

require 'vendor/autoload.php';

use Otus\Connection as Connection;
use Otus\Creator as Creator;

//setting default credits
$connectionData = ['host' => 'localhost', 'port' => 5432, 'user' => 'postgres', 'password' => 'adminPassword', 'database' => 'test_db2', 'schema' => 'test_db'];
//getting options
$options = getopt("h", ['help', 'host:', 'port:', 'user:', 'password:', 'database:', 'schema:']);
/**
 *  TODO
 *  Maybe use extract($options) and check options by isset($opt) ?
 *  Maybe... not now..
 */
if (array_key_exists('h', $options) || array_key_exists('help', $options)) {
    echo "Options:\n'--host' - host(default: localhost),\n"
        . "'--port' - port(default: 5432),\n"
        . "'--user' - user(default: postgres),\n"
        . "'--password' - password(default: adminPassword),\n"
        . "'--database' - database(default: test_db),\n"
        . "'--schema' - schema(default: test_db),\n"
        . "'-h\\--help' - this message." . PHP_EOL;
    exit();
}
!array_key_exists('host', $options) ? : $connectionData['host'] = $options['host'];
!array_key_exists('port', $options) ? : $connectionData['port'] = $options['port'];
!array_key_exists('user', $options) ? : $connectionData['user'] = $options['user'];
!array_key_exists('password', $options) ? : $connectionData['password'] = $options['password'];
!array_key_exists('database', $options) ? : $connectionData['database'] = $options['database'];
!array_key_exists('schema', $options) ? : $connectionData['schema'] = $options['schema'];
try {
    // Check DB exists
    $pdo = Connection::get()->connect($connectionData['host'], $connectionData['port'], $connectionData['user'], $connectionData['password']);
    $creator = new Creator($pdo, ['database' => $connectionData['database'], 'schema' => $connectionData['schema'], 'user' => $connectionData['user']]);

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
    // Change connection to chosen DB
    $pdo = Connection::get()->connect($connectionData['host'], $connectionData['port'], $connectionData['user'], $connectionData['password'], $connectionData['database']);
    $creator->setPdo($pdo);

    // Check schema exists
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
    echo 'Database creating complete' . PHP_EOL;
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
    die();
}