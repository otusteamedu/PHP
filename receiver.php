<?php

$socketFilePath = sys_get_temp_dir() . '/myserver.sock';
if(file_exists($socketFilePath)) {
    unlink($socketFilePath);
}

$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

if (socket_bind($socket, $socketFilePath) === false) {
    echo "bind failed";
    die;
}

if (socket_recvfrom($socket, $buf, 64 * 1024, 0, $source) === false) {
    echo "recv_from failed";
}

echo "received: " . $buf . "\n";

socket_close($socket);

unlink($socketFilePath);