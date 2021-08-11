<?php

use \Sockets\serverSocket;

$client = new Sockets\clientSocket(
    $_ENV['CLIENT_SOCKET_HOST'],
    $_ENV['CLIENT_SOCKET_FILE'],
    $_ENV['CLIENT_SOCKET_PORT'],
    $_ENV['CLIENT_SOCKET_DOMAIN'],
);
$client->start();

