<?php

namespace Socket;

use Exception;

/**
 * Class SocketServer
 *
 * @package Socket
 */
class SocketServer
{
    /**
     * @param SocketFile $serverSocketFile
     *
     * @throws Exception
     */
    public static function run (SocketFile $serverSocketFile): void
    {
        $socket = SocketCreator::make();

        $serverSocketFilePath = $serverSocketFile->getFilePath();
        $serverSocketFile->unlink();

        if (!socket_bind($socket, $serverSocketFilePath)) {
            throw new Exception("Unable to bind to {$serverSocketFilePath}");
        }

        while (true) {
            if (!socket_set_block($socket)) {
                throw new Exception('Unable to set blocking mode for socket');
            }

            $buf  = '';
            $from = '';

            echo "Ready to receive messages...\n";

            $bytesReceived = socket_recvfrom($socket, $buf, 65536, 0, $from);

            if ($bytesReceived === -1) {
                throw new Exception('An error occured while receiving from the socket');
            }

            echo "Received $buf from $from\n";

            $buf .= "->Response";

            if (!socket_set_nonblock($socket)) {
                throw new Exception('Unable to set nonblocking mode for socket');
            }

            $len = strlen($buf);

            $bytesSent = socket_sendto($socket, $buf, $len, 0, $from);
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