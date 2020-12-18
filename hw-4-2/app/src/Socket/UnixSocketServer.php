<?php

namespace Socket;

use Exception;

/**
 * Class UnixSocketServer
 *
 * @package Socket
 */
class UnixSocketServer extends UnixSocket
{
    /**
     * @throws Exception
     */
    public function start (): void
    {
        $this->_bindSock($this->_config['server_filename']);

        while (true) {
            if (!socket_set_block($this->_socket)) {
                throw new Exception('Unable to set blocking mode for socket');
            }

            $buf  = '';
            $from = '';

            echo "Ready to receive messages...\n";

            $bytesReceived = socket_recvfrom($this->_socket, $buf, 65536, 0, $from);

            if ($bytesReceived === -1) {
                throw new Exception('An error occured while receiving from the socket');
            }

            echo "Received $buf from $from\n";

            $buf .= "->Response";

            if (!socket_set_nonblock($this->_socket)) {
                throw new Exception('Unable to set nonblocking mode for socket');
            }

            $len = strlen($buf);

            $bytesSent = socket_sendto($this->_socket, $buf, $len, 0, $from);
            if ($bytesSent === -1) {
                throw new Exception('An error occured while sending to the socket');
            }
            else if ($bytesSent != $len) {
                throw new Exception("$bytesSent bytes have been sent instead of the $len bytes expected");
            }

            echo "Request processed\n";
        }
    }
}