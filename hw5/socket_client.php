<?php
$address = '192.168.1.64';
$port = 10003;

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

if (socket_connect($socket, $address, $port) === false) {
    echo "socket_connect error";
}
do {
    $msg = readline(" : ");
    $msg = trim($msg);
    socket_write($socket, $msg, strlen($msg));
    if ($msg === 'quit') {
        break;
    }
    $answer = socket_read($socket, 2048, PHP_BINARY_READ);
    $answer = trim($answer);
    if ($answer === 'quit') {
        break;
    }
    print sprintf("Server answer: %s\n", $answer);
} while (true);

socket_close($socket);
