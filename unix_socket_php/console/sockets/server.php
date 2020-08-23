<?php

use sockets\exceptions\SocketsException;

try {
    $server = new sockets\Server(
        $_ENV['SOCKET_PATH'],
        $_ENV['SOCKET_PORT'],
    );

    $server->listen();

} catch (SocketsException $e) {
    echo 'SocketsException', PHP_EOL;
}