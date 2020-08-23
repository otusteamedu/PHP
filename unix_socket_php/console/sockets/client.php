<?php

use sockets\exceptions\SocketsException;

try {
    $client = new sockets\Client(
        $_ENV['SOCKET_PATH'],
        $_ENV['SOCKET_PORT'],
    );

    while (true)
    {
        $client->run();
    }

} catch (SocketsException $e) {
    echo 'Can not connect to server', PHP_EOL;
}
