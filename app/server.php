<?php

require 'vendor/autoload.php';

$file = "./server.sock";
unlink($file);

$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

if ($socket === false) {
    $errorCode = socket_last_error();
    $errorMsg = socket_strerror($errorCode);
    die("create socket failed: [$errorCode] $errorMsg");
}


if (socket_bind($socket, $file) === false) {
    $errorCode = socket_last_error($socket);
    $errorMsg = socket_strerror($errorCode);
    echo "bind failed: [$errorCode] $errorMsg" . PHP_EOL;
}

if (socket_recvfrom($socket, $buf, 64 * 1024, 0, $source) === false) {
    $errorCode = socket_last_error($socket);
    $errorMsg = socket_strerror($errorCode);
    echo "recv_from failed: [$errorCode] $errorMsg" . PHP_EOL;
}

echo "received: " . $buf . PHP_EOL;
