<?php
const SLEEP_TIME = 100000;
const SOCKET_NO_MESSAGE = 11;
const SOCKET_PATH = 'chat.sock';

$stdIn = fopen('php://stdin', 'r');
$socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

stream_set_blocking($stdIn, false);
socket_set_nonblock($socket);

$isConnected = socket_connect($socket, SOCKET_PATH);

if ($isConnected) {
    echo "Connected to server! " . PHP_EOL;
    while (true) {
        $line = trim(fgets(STDIN));

        if ($line !== false) {
            socket_write($socket, $line);
        }

        $response = socket_read($socket, 1024);
        if ($response === false || $response === '') {
            $errno = socket_last_error($socket);
            if ($errno !== SOCKET_NO_MESSAGE) {
                echo "Error: {$errno} " . socket_strerror($errno) . PHP_EOL;
                break;
            }
        } else {
            echo "> " . $response . PHP_EOL;
        }
        
        usleep(SLEEP_TIME);
    }
} else {
    echo "Can't connect to " . SOCKET_PATH . PHP_EOL;
}