<?php
if (!extension_loaded('sockets')) {
    die('The sockets extension is not loaded.');
}
// create unix udp socket
$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
if (!$socket) {
    die('Unable to create AF_UNIX socket');
}

// same socket will be later used in recv_from
// no binding is required if you wish only send and never receive
$client_side_sock = dirname(__FILE__)."/client.sock";
if (!socket_bind($socket, $client_side_sock)) {
    die("Unable to bind to $client_side_sock");
}

// use socket to send data
if (!socket_set_nonblock($socket)) {
    die('Unable to set nonblocking mode for socket');
}
// server side socket filename is known apriori
$server_side_sock = dirname(__FILE__)."/server.sock";
$msg = "Message";
$len = strlen($msg);
// at this point 'server' process must be running and bound to receive from serv.sock
$bytes_sent = socket_sendto($socket, $msg, $len, 0, $server_side_sock);
if ($bytes_sent == -1) {
    die('An error occured while sending to the socket');
} elseif ($bytes_sent != $len) {
    die($bytes_sent . ' bytes have been sent instead of the ' . $len . ' bytes expected');
}

// use socket to receive data
if (!socket_set_block($socket)) {
    die('Unable to set blocking mode for socket');
}
$buf = '';
$from = '';
// will block to wait server response
$bytes_received = socket_recvfrom($socket, $buf, 65536, 0, $from);
if ($bytes_received == -1) {
    die('An error occured while receiving from the socket');
}
echo "Received $buf from $from\n";

// close socket and delete own .sock file
socket_close($socket);
unlink($client_side_sock);
echo "Client exits\n";
