<?php

use Otus\Sockets\Exceptions\SocketException;
use Otus\Sockets\Server;

require 'init.php';

try {
    $server = new Server($_ENV['SOCKET_PATH'], $_ENV['SOCKET_PORT']);
    $server->listen();
} catch (SocketException $e) {
    echo 'SocketException ' . PHP_EOL;
}