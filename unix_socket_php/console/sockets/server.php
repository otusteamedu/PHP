<?php

use sockets\exceptions\SocketsException;

require 'init.php';

try {
    $server = new sockets\Server(
        $_ENV['SOCKET_PATH'],
        $_ENV['SOCKET_PORT'],
    );

    $server->listen();

} catch (SocketsException $e) {
    echo 'SocketsException', PHP_EOL;
}