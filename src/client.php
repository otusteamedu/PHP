<?php

error_reporting(E_ERROR);

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    die('Unable to create a socket. Check if you have started the socket.php' . PHP_EOL);
}

if (false === socket_connect($socket, '0.0.0.0', 8000)) {
    die('Unable to connect to the socket' . PHP_EOL);
}

$messages = [
    'Hello from a client!',
    'Another hello from a client!',
    'Yet another hello from a client!',
];

while ($message = array_pop($messages)) {
    if (false === socket_write($socket, $message . "\n")) {
        die('Failed to send the message to the server' . PHP_EOL);
    }
    sleep(1);
}
