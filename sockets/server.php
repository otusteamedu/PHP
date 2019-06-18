<?php
if (!extension_loaded("sockets")) {
    die("The sockets extension is not loaded.\n");
}

$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
if (!$socket) {
    die("Unable to create AF_UNIX socket\n");
}

$server_side_sock = __DIR__ . '/server.sock';

if (file_exists ($server_side_sock)) {
    unlink($server_side_sock);
}

if (!socket_bind($socket, $server_side_sock)) {
    die("Unable to bind to $server_side_sock\n");
}

while (true) {

    if (!socket_set_block($socket)) {
        die("Unable to set blocking mode for socket");
    }

    $buf = "";
    $from = "";

    echo "Waiting for connect\n";

    $bytes_received = socket_recvfrom($socket, $buf, 65536, 0, $from);
    if ($bytes_received == -1) {
        die("An error occured while receiving from the socket");
    }

    echo "Server Side:\nReceived from client:\n$buf\nfrom\n$from\n";

    $response_txt = "We get your message. All OK :-)"; // process client query here

    if (!socket_set_nonblock($socket)) {
        die("Unable to set nonblocking mode for socket");
    }


    $len = strlen($response_txt);
    $bytes_sent = socket_sendto($socket, $response_txt, $len, 0, $from);

    if ($bytes_sent == -1) {
        die("An error occured while sending to the socket");
    } elseif ($bytes_sent != $len) {
        die($bytes_sent . " bytes have been sent instead of the $len bytes expected");
    }

    echo "\nRequest processed OK\n";
}
