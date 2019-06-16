<?php

if (!extension_loaded('sockets')) {
    die('The sockets extension is not loaded.');
}
// create unix udp socket
$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
if (!$socket)
    die('Unable to create AF_UNIX socket');

// same socket will be used in recv_from and send_to
$server_side_sock = dirname(__FILE__) . "/server.sock";
if (!socket_bind($socket, $server_side_sock))
    die("Unable to bind to $server_side_sock");

while (1) // server never exits
{
// receive query
    if (!socket_set_block($socket))
        die('Unable to set blocking mode for socket');
    $buf = '';
    $from = '';
    echo "Ready to receive...\n";
// will block to wait client query
    $bytes_received = socket_recvfrom($socket, $buf, 65536, 0, $from);
    if ($bytes_received == -1)
        die('An error occured while receiving from the socket');
    echo "Received $buf from $from\n";

    $buf .= "->Response"; // process client query here

// send response
    if (!socket_set_nonblock($socket))
        die('Unable to set nonblocking mode for socket');
// client side socket filename is known from client request: $from
    $len = strlen($buf);
    $bytes_sent = socket_sendto($socket, $buf, $len, 0, $from);
    if ($bytes_sent == -1)
        die('An error occured while sending to the socket');
    else if ($bytes_sent != $len)
        die($bytes_sent . ' bytes have been sent instead of the ' . $len . ' bytes expected');
    echo "Request processed\n";
}