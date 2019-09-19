<?php

$socketFilePath = sys_get_temp_dir() . '/myserver.sock';

$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
socket_sendto($socket, "Hello World!", 12, 0, $socketFilePath, 0);
echo "sent\n";