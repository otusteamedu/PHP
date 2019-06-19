<?php

$address = '192.168.1.64';
$port = 10003;

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_bind($socket, $address, $port);
socket_listen($socket, 2);

do {
    $mgsock = socket_accept($socket);
    do {
        $buffer = socket_read($mgsock, 2048, PHP_BINARY_READ);
        $buffer = trim($buffer);
        if ($buffer === 'quit') {
            break;
        }
        print sprintf("Client said: %s\n", $buffer);
        $msg = readline(" : ");
        socket_write($mgsock, $msg, strlen($msg));
    } while (true);
    socket_close($mgsock);
} while (true);
socket_close($socket);


