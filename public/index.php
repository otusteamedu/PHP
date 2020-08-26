<?php

require __DIR__ .  '/../bootstrap/app.php';

use Otus\Sockets\Exceptions\SocketException;
use Otus\Sockets\Server;
use Otus\Sockets\Client;

try {
    $server = new Server($_ENV['SOCKET_PATH'], $_ENV['SOCKET_PORT']);
    $server->test();
} catch (SocketException $e) {
    echo 'SocketException ' . PHP_EOL;
}

try {
    $client = new Client($_ENV['SOCKET_PATH'], $_ENV['SOCKET_PORT']);
    $client->test();
} catch (SocketException $e) {
    echo 'SocketException ' . PHP_EOL;
}