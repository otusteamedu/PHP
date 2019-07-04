<?php

error_reporting(E_ERROR);

set_time_limit(0);

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    die('Unable to create a socket' . PHP_EOL);
}

if (false === socket_bind($socket, '127.0.0.1', 8000)) {
    die('Unable to bind the socket' . PHP_EOL);
}

if (false === socket_listen($socket, 1000)) {
    die('Unable to start listen the socket' . PHP_EOL);
}

echo "Waiting for clients..." . PHP_EOL;
while ($client = socket_accept($socket)) {

    echo "Got a new client. Reading the message from a client..." . PHP_EOL;

    while ($str = socket_read($client, 2048, PHP_BINARY_READ)) {
        if (empty($str)) {
            break;
        }
        echo $str;
    }

    echo "Finished reading the message from the client" . PHP_EOL;
}

echo "Server stopped" . PHP_EOL;
