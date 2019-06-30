<?php

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_bind($socket, '127.0.0.1', '1013');
socket_listen($socket, 1);

do {
    if (($msgsock = socket_accept($socket)) === false) {
        echo "socket_accept() failed: reason: " . socket_strerror($msgsock) . "\n";
        break;
    }
    echo "Client joined!\n";
    do {
        $client_msg = socket_read($msgsock, 2048);
        echo "client: $client_msg\n";
        
        if ($client_msg == 'quit') {
            socket_close($msgsock);
            break 2;
        }
        
        if ($server_msg = readline("server: ")) {
            socket_write($msgsock, $server_msg, strlen($server_msg));
        }
        
    } while (true);
    
    socket_close($socket);
    
} while (true);

socket_close($socket);