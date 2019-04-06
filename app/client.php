<?php

require 'vendor/autoload.php';

$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

if ($socket === false) {
    $errorCode = socket_last_error();
    $errorMsg = socket_strerror($errorCode);
    die("Не могу создать сокет: [$errorCode] $errorMsg");
}

$res = socket_sendto($socket, "Hello World!", 12, 0, "./server.sock", 0);

if ($res === false) {
    die("Отправка не удалась.");
} else {
    echo "sent" . PHP_EOL;
}

