<?php
set_time_limit(0);

ob_implicit_flush();

$serverSocketFile = 'php_server.sock';

$clientSocket = socket_create(AF_UNIX, SOCK_STREAM, 0);

if ($clientSocket === false) {
    die('Unable to create server socket. Reason: '.socket_strerror(socket_last_error()).PHP_EOL);
}

$connect = socket_connect($clientSocket, $serverSocketFile);
if ($connect === false) {
    die('Unable to connect to server socket. Reason: '.socket_strerror(socket_last_error()).PHP_EOL);
}


$handle = fopen('php://stdin', 'r');
while (true) {
    while (true) {
        $msg = socket_read($clientSocket, 1000000, PHP_NORMAL_READ);
        if ($msg === false) {
            break;
        }
        $msg = trim($msg);
        if ($msg === '') {
            break;
        }
        echo $msg.PHP_EOL;
        break;
    }

    $line = fgets($handle);
    if (trim($line) !== '') {
        socket_write($clientSocket, $line, strlen($line));
    }
}

socket_close($clientSocket);