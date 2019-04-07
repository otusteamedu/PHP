<?php

require 'vendor/autoload.php';

$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

if ($socket === false) {
    $errorCode = socket_last_error();
    $errorMsg = socket_strerror($errorCode);
    die("create socket failed: [$errorCode] $errorMsg");
}

$res = socket_sendto($socket, "Hello World!", 12, 0, "./server.sock", 0);

echo ($res === false ? 'send failed' : 'sent') . PHP_EOL;


