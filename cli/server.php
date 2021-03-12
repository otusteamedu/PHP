<?php
use \Sockets\serverSocket;

$createdObject = ($_ENV['SERVER_SOCKET_MULTICONNECTION'] == 'true') ? 'Sockets\serverConnections' : 'Sockets\serverSocket';
$server = new $createdObject(
    $_ENV['SERVER_SOCKET_HOST'],
    $_ENV['SERVER_SOCKET_PATH'],
    $_ENV['SERVER_SOCKET_PORT'],
    $_ENV['SERVER_SOCKET_DOMAIN'],
    $_ENV['SERVER_SOCKET_MAX_CONNECTIONS'],
    $_ENV['SERVER_SOCKET_BUFFER_LENGTH'],
);
$server->start();

