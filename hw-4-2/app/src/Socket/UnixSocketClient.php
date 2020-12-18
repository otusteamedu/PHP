<?php

namespace Socket;

use Exception;

/**
 * Class UnixSocketClient
 *
 * @package Socket
 */
class UnixSocketClient extends UnixSocket
{
    /**
     * @throws Exception
     */
    public function start (): void
    {
        $this->_bindSock($this->_config['client_filename']);

        if (!socket_set_block($this->_socket)) {
            throw new Exception('Unable to set blocking mode for socket');
        }

        $serverSideSock = $this->_getSockFilePath($this->_config['server_filename']);

        $msg = "Hello World";
        $len = strlen($msg);

        $bytesSent = socket_sendto($this->_socket, $msg, $len, 0, $serverSideSock);
        if ($bytesSent === -1) {
            throw new Exception('An error occured while sending to the socket');
        }
        else if ($bytesSent != $len) {
            throw new Exception("$bytesSent bytes have been sent instead of the $len bytes expected");
        }

        if (!socket_set_block($this->_socket)) {
            throw new Exception('Unable to set blocking mode for socket');
        }

        $buf  = '';
        $from = '';

        $bytesReceived = socket_recvfrom($this->_socket, $buf, 65536, 0, $from);

        if ($bytesReceived === -1) {
            throw new Exception('An error occured while receiving from the socket');
        }

        echo "Received $buf from $from\n";

        socket_close($this->_socket);
        $this->_unlinkSock($this->_getSockFilePath($this->_config['client_filename']));

        echo "Client exits\n";
    }
}
