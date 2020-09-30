<?php

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load;
$host = $_ENV['HOST'];
$port = $_ENV['PORT'];

$client = new Client($host, $port);
$client->waitForMessage();