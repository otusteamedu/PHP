<?php

require 'vendor/autoload.php';

$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
socket_sendto($socket, "Hello World!", 12, 0, "./server.sock", 0);
echo "sent" . PHP_EOL;