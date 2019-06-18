<?php
if (!extension_loaded("sockets")) {
    die("The sockets extension is not loaded.\n");
}

$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
if (!$socket) {
    die("Unable to create AF_UNIX socket\n");
}

$client_side_sock = __DIR__ . "/client.sock";

if (file_exists ($client_side_sock)) {
    unlink($client_side_sock);
}

if (!socket_bind($socket, $client_side_sock)) {
    die("Unable to bind to $client_side_sock\n");
}

if (!socket_set_nonblock($socket)) {
    die("Unable to set nonblocking mode for socket\n");
}

$server_side_sock = __DIR__ . "/server.sock";

while ($msg = fgets(STDIN)) {

    $len = strlen($msg);

    $bytes_sent = socket_sendto($socket, $msg, $len, 0, $server_side_sock);

    if ($bytes_sent == -1) {
        die("An error occured while sending to the socket\n");
    }
    elseif ($bytes_sent != $len) {
        die("$bytes_sent bytes have been sent instead of the $len bytes expected\n");
    }

    if (!socket_set_block($socket)) {
        die("Unable to set blocking mode for socket\n");
    }

    $buf = '';
    $from = '';

    $bytes_received = socket_recvfrom($socket, $buf, 65536, 0, $from);
    if ($bytes_received == -1) {
        die("An error occured while receiving from the socket\n");
    }

    echo "\nResponse from server:\n$buf\nfrom\n$from\n";

}

socket_close($socket);
unlink($client_side_sock);
