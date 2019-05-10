#!/usr/bin/env php
<?php

require 'vendor/autoload.php';

use Otus\Connection;
use Otus\Inserter;

//setting default credits
$connectionData = ['host' => 'localhost', 'port' => 5432, 'user' => 'postgres', 'password' => 'adminPassword', 'database' => 'test_db2', 'schema' => 'test_db'];
//getting options
$options = getopt("h", ['help', 'host:', 'port:', 'user:', 'password:', 'database:', 'schema:', 'type:']);
/**
 *  TODO
 *  Maybe use extract($options) and check options by isset($opt) ?
 *  Maybe... not now..
 */
if (array_key_exists('h', $options) || array_key_exists('help', $options)) {
    echo "Options:\n"
        . "'--type' - type of inserting data (\"s\" - for small data(~10000 rows), \"b\" - for big data(~10000000 rows))\n"
        . "'--host' - host(default: localhost),\n"
        . "'--port' - port(default: 5432),\n"
        . "'--user' - user(default: postgres),\n"
        . "'--password' - password(default: adminPassword),\n"
        . "'--database' - database(default: test_db),\n"
        . "'--schema' - schema(default: test_db),\n"
        . "'-h\\--help' - this message." . PHP_EOL;
    exit();
}
if (!array_key_exists('type', $options)) {
    echo 'Error: You must choose type of insert data, "s" - for small data(~10000 rows), "b" - for big data(~10000000 rows).' . PHP_EOL;
    echo 'Example: ./insertData.php --type s' . PHP_EOL;
    die();
} elseif(!in_array($options['type'], ['s', 'b'])) {
    echo 'Error: You must choose type of insert data, "s" - for small data(~10000 rows), "b" - for big data(~10000000 rows).' . PHP_EOL;
    echo 'Example: ./insertData.php --type s' . PHP_EOL;
    die();
} else {
    $type = $options['type'];
}
!array_key_exists('host', $options) ? : $connectionData['host'] = $options['host'];
!array_key_exists('port', $options) ? : $connectionData['port'] = $options['port'];
!array_key_exists('user', $options) ? : $connectionData['user'] = $options['user'];
!array_key_exists('password', $options) ? : $connectionData['password'] = $options['password'];
!array_key_exists('database', $options) ? : $connectionData['database'] = $options['database'];
!array_key_exists('schema', $options) ? : $connectionData['schema'] = $options['schema'];
try {
    $pdo = Connection::get()->connect($connectionData['host'], $connectionData['port'], $connectionData['user'], $connectionData['password'], $connectionData['database']);
    $pdo->exec('SET search_path TO ' . $connectionData['schema']);
    $inserter = new Inserter($pdo);
    switch ($type) {
        case 's':
            echo 'Inserting small dataset (~10000 rows)' . PHP_EOL;
            $inserter->insertData(10000);
            break;
        case 'b':
            echo 'Inserting big dataset (~10000000 rows)' . PHP_EOL;
            $inserter->insertData(10000000);
            break;
    }
    exit();
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
    die();
}