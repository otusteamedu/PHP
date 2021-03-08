<?php

use \Sockets\serverSocket;

try {
    $client = new Sockets\clientSocket(
        $_ENV['CLIENT_SOCKET_HOST'],
        $_ENV['CLIENT_SOCKET_PATH'],
        $_ENV['CLIENT_SOCKET_PORT'],
        $_ENV['CLIENT_SOCKET_DOMAIN'],
    );
    $client->start();
} catch (\Exception $exception) {
    throw new Exception($exception->getMessage(),$exception->getCode());
}
