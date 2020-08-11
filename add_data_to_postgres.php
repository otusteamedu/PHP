<?php

include_once "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$faker = Faker\Factory::create();

$driver = $_ENV['driver'] ?? null;
$dbname = $_ENV['dbname'] ?? null;
$host   = $_ENV['host']   ?? null;
$user   = $_ENV['user']   ?? null;
$pass   = $_ENV['pass']   ?? null;

if (isset($driver) && isset($dbname) && isset($host) && isset($user) && isset($pass)) {
    $dbh = new PDO("{$driver}:dbname={$dbname};host={$host}", $user, $pass);

    # TODO add 10000 writes
    
    # TODO add 10000000 writes
} else {
    echo "Error: db no connection.";
}



