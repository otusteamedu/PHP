<?php

$socket = socket_create(AF_UNIX,SOCK_DGRAM,0);

$server_socket_file = 'server.sock';

if (file_exists($server_socket_file)) {
    unlink($server_socket_file);
}
socket_bind($socket, $server_socket_file);

while(1) {

    echo "Ready for the message ...\n\n";
    socket_recvfrom($socket,$received_message,255,0,$sender);

    echo "Received message from $sender:\n";
    echo "$received_message\n";

    $received_message = substr($received_message,0,-1);
    $response_string = "Your message: \"$received_message\" has been accepted successfully!";
    socket_sendto($socket,$response_string, 255, 0, $sender);
    echo "Response was sent to $sender\n\n";
}