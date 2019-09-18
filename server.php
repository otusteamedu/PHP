<?php

$socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
if (!$socket) {
    die('Unable to create AF_UNIX socket . PHP_EOL');
}

$serverSocketPath = dirname(__FILE__)."/server_socket.sock";

if (!socket_bind($socket, $serverSocketPath)) {
    die("Unable to bind to " . PHP_EOL);
}

if(!socket_listen($socket,1)) {
    die("Unable to listent socket" . PHP_EOL);
}
$sock = socket_accept($socket);

for ($i=0; $i < 3; $i++) { 
    sleep (10);
    socket_write($sock, "message from server socket!!!" . PHP_EOL, 1024);
    echo socket_read($sock, 1024);
}
socket_close($sock);
unlink($serverSocketPath);