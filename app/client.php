<?php
$message = "Send message test";
echo "Message To server : '$message'\n";

$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Create socket error!\n");
$result = socket_connect($socket, "127.0.0.1", "4545") or die("Connection to server error!\n");
socket_write($socket, $message, strlen($message)) or die("Sending data to server error!\n");
$result = socket_read ($socket, 1024) or die("Reading server response error!\n");
echo "Reply from server: '$result'\n";
socket_close($socket);