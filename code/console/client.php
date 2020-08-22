<?php

require 'vendor/autoload.php';

use Penguin\Sockets\Client;


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

try {
    $client = new Client($_ENV['SOCKET_PATH'], $_ENV['SOCKET_PORT']);
    $client->run();
} catch (Exception $error) {
    echo $error->getMessage();
}



