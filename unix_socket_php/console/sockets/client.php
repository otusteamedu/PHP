<?php

use sockets\exceptions\SocketsException;

require 'init.php';

try {
    $client = new sockets\Client(
        $_ENV['SOCKET_PATH'],
        $_ENV['SOCKET_PORT'],
    );

    while (true) {
        $client->waitForMessage();
        $client->waitingResponse();
    }


} catch (SocketsException $e) {
    echo 'Can not connect to server', PHP_EOL;
}
