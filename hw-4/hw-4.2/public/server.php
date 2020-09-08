<?php

use App\Exceptions\SocketsException;
use App\Server;

require __DIR__.'/../bootstrap.php';

try {
    $server = new Server(
        $_ENV['SOCKET_PATH'],
        $_ENV['SOCKET_PORT'],
    );

    $server->listen();

} catch (SocketsException $e) {
    echo 'SocketsException', PHP_EOL;
}
