<?php

$socket = socket_create(AF_UNIX,SOCK_DGRAM,0);

$server_socket_file = 'server.sock';
$client_socket_file = 'client.sock';

if (file_exists($client_socket_file)) {
    unlink($client_socket_file);
}
socket_bind($socket, $client_socket_file);

while(1) {
    echo "Enter your message to the server:\n";
    $message_to_send = fgets(STDIN);

    socket_sendto($socket, $message_to_send, 255, 0, $server_socket_file);

    socket_recvfrom($socket,$received_message,255,0,$sender);

    echo "\nResponse from $sender:\n";
    echo "$received_message\n\n";
}
