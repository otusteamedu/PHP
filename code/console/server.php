<?php

require 'vendor/autoload.php';

use Penguin\Sockets\Server;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


try {
    $server = new Server($_ENV['SOCKET_PATH'], $_ENV['SOCKET_PORT']);
    $server->run();
} catch (Exception $error) {
    echo $error->getMessage();
}

