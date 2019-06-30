<?php

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

if (socket_connect($socket, '127.0.0.1', '1013')) {
    echo "Joined to server!\n";
    do {
        $client_msg = readline("\nclient: ");
        socket_write($socket, $client_msg, strlen($client_msg));
        
        if ($client_msg == 'quit') {
            break;
        }
        
        if ($server_msg = socket_read($socket, 2048)) {
            echo "server: {$server_msg}\n";
        }
    } while(true);
}

socket_close($socket);