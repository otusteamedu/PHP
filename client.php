<?php

$socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
if (!$socket) {
    die('Unable to create AF_UNIX socket . PHP_EOL');
}

$serverSocketPath = dirname(__FILE__)."/server_socket.sock";

if(!socket_connect($socket,$serverSocketPath)) {
    die("Unable to connect socket" . PHP_EOL);
}

for ($i=0; $i < 3; $i++) { 
    socket_write($socket, "message from client socket!!!" . PHP_EOL, 1024);
    sleep (10);
    echo socket_read($socket, 1024);
}
socket_close($socket);