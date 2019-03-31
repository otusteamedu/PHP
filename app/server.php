<?php

require 'vendor/autoload.php';

$file = "./server.sock";
unlink($file);

$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

if (socket_bind($socket, $file) === false) {
    echo "bind failed" . PHP_EOL;
}

if (socket_recvfrom($socket, $buf, 64 * 1024, 0, $source) === false) {
    echo "recv_from failed" . PHP_EOL;
}

echo "received: " . $buf . PHP_EOL;
