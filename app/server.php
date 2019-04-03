<?php
set_time_limit(0);

$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Create socket error!\n");
$result = socket_bind($socket, "127.0.0.1", "4545") or die("Bind to socket error!\n");
$result = socket_listen($socket, 3) or die("Set up socket listener error!\n");

echo "server started!\n";

$spawn = socket_accept($socket) or die("Accept incoming connection error!\n");
$input = socket_read($spawn, 1024) or die("Read input from client error!\n");
$input = trim($input);
echo "Client message: $input\n";

$output = "All is  ok!";
socket_write($spawn, $output, strlen ($output)) or die("Could not write output\n");

socket_close($spawn);
socket_close($socket);
