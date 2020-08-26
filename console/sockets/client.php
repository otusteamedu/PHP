<?php

use Otus\Sockets\Exceptions\SocketException;
use Otus\Sockets\Client;

require 'init.php';

try {
    $client = new Client($_ENV['SOCKET_PATH'], $_ENV['SOCKET_PORT']);
    $client->connect();
} catch (SocketException $e) {
    echo 'SocketException ' . PHP_EOL;
}