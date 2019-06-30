<?php
if (!extension_loaded("sockets")) {
    die("The sockets extension is not loaded.\n");
}
// create unix udp socket
$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
if (!$socket) {
    die("Unable to create AF_UNIX socket\n");
}

// same socket will be later used in recv_from
// no binding is required if you wish only send and never receive
$client_side_sock = __DIR__ . "/client.sock";
if (file_exists ($client_side_sock)) {
    unlink($client_side_sock);
}
if (!socket_bind($socket, $client_side_sock)) {
    die("Unable to bind to $client_side_sock\n");
}

// use socket to send data
if (!socket_set_nonblock($socket)) {
    die("Unable to set nonblocking mode for socket\n");
}

// server side socket filename is known apriori
$server_side_sock = __DIR__ . "/server.sock";
while ($msg = fgets(STDIN)) {
    $len = strlen($msg);
    // at this point 'server' process must be running and bound to receive from serv.sock
    $bytes_sent = socket_sendto($socket, $msg, $len, 0, $server_side_sock);
    if ($bytes_sent == -1) {
        die("An error occured while sending to the socket\n");
    }
    elseif ($bytes_sent != $len) {
        die("$bytes_sent bytes have been sent instead of the $len bytes expected\n");
    }
    // use socket to receive data
    if (!socket_set_block($socket)) {
        die("Unable to set blocking mode for socket\n");
    }
    $buf = '';
    $from = '';
    // will block to wait server response
    $bytes_received = socket_recvfrom($socket, $buf, 65536, 0, $from);
    if ($bytes_received == -1) {
        die("An error occured while receiving from the socket\n");
    }
    echo "\nReceived: \"$buf\" from $from\n";
}

// close socket and delete own .sock file
socket_close($socket);
unlink($client_side_sock);
