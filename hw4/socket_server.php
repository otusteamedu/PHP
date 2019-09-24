<?php
const SLEEP_TIME = 100000;
const SOCKET_NO_MESSAGE = 11;
const SOCKET_PATH = 'chat.sock';

if (file_exists(SOCKET_PATH)) {
    unlink(SOCKET_PATH);
}

$stdIn = fopen('php://stdin', 'r');
stream_set_blocking($stdIn, false);

$socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

$bindSuccess = socket_bind($socket, SOCKET_PATH);
if (!$bindSuccess) {
    die('Failed to bind socket: ' . socket_strerror(socket_last_error()));
}

$listenSuccess = socket_listen($socket);
if (!$listenSuccess) {
    die('Failed to bind socket: ' . socket_strerror(socket_last_error()));
}

while (true) {
    echo 'Wait connection...' . PHP_EOL;
    $connection = socket_accept($socket);
    socket_set_nonblock($connection);
    echo 'Client connected!' . PHP_EOL;

    while (true) {
        $line = trim(fgets(STDIN));

        if ($line !== false) {
            socket_write($connection, $line);
        }

        $response = socket_read($connection, 1024);
        if ($response === false || $response === '') {
            $errno = socket_last_error($connection);
            if ($errno !== SOCKET_NO_MESSAGE) {
                echo "Error: {$errno} " . socket_strerror($errno) . PHP_EOL;
                break;
            }
        } else {
            echo "> " . $response . PHP_EOL;
        }

        usleep(SLEEP_TIME);
    }
    usleep(SLEEP_TIME);
}

socket_shutdown($socket);
socket_close($socket);

if (file_exists(SOCKET_PATH)) {
    unlink(SOCKET_PATH);
}