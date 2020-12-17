<?php

namespace Socket;

use Exception;

class UnixSocketServer extends UnixSocket
{
    private $_socket;

    public function __construct()
    {
        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if ($socket === false) {
            throw new Exception('Unable to create AF_UNIX socket');
        }

        $this->_socket = $socket;
    }

    public function start()
    {
        $server_side_sock = dirname(__FILE__)."/server.sock";
        if (!socket_bind($this->_socket, $server_side_sock)) {
            throw new Exception("Unable to bind to $server_side_sock");
        }

        while (true) {
            if (!socket_set_block($this->_socket)) {
                throw new Exception('Unable to set blocking mode for socket');
            }

            $buf  = '';
            $from = '';

            echo "Ready to receive...\n";

            $bytes_received = socket_recvfrom($this->_socket, $buf, 65536, 0, $from);

            if ($bytes_received === -1) {
                throw new Exception('An error occured while receiving from the socket');
            }

            echo "Received $buf from $from\n";

            $buf .= "->Response";

            if (!socket_set_nonblock($this->_socket)) {
                throw new Exception('Unable to set nonblocking mode for socket');
            }

            $len = strlen($buf);

            $bytes_sent = socket_sendto($this->_socket, $buf, $len, 0, $from);
            if ($bytes_sent === -1) {
                throw new Exception('An error occured while sending to the socket');
            }
            else if ($bytes_sent != $len) {
                throw new Exception("$bytes_sent bytes have been sent instead of the $len bytes expected");
            }

            echo "Request processed\n";
        }
    }
}