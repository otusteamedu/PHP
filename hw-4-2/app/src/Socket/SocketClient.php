<?php

namespace Socket;

use Exception;

/**
 * Class SocketClient
 *
 * @package Socket
 */
class SocketClient
{
    /**
     * @param SocketFile $clientSocketFile
     * @param SocketFile $serverSocketFile
     *
     * @throws Exception
     */
    public static function run (SocketFile $clientSocketFile, SocketFile $serverSocketFile): void
    {
        $socket = SocketCreator::make();

        $clientSocketFilePath = $clientSocketFile->getFilePath();

        if (!socket_bind($socket, $clientSocketFilePath)) {
            throw new Exception("Unable to bind to {$clientSocketFilePath}");
        }

        $msg = "Hello World";
        $len = strlen($msg);

        $bytesSent = socket_sendto($socket, $msg, $len, 0, $serverSocketFile->getFilePath());
        if ($bytesSent === -1) {
            throw new Exception('An error occured while sending to the socket');
        }
        else if ($bytesSent != $len) {
            throw new Exception("$bytesSent bytes have been sent instead of the $len bytes expected");
        }

        if (!socket_set_block($socket)) {
            throw new Exception('Unable to set blocking mode for socket');
        }

        $buf  = '';
        $from = '';

        $bytesReceived = socket_recvfrom($socket, $buf, 65536, 0, $from);

        if ($bytesReceived === -1) {
            throw new Exception('An error occured while receiving from the socket');
        }

        echo "Received $buf from $from\n";

        socket_close($socket);
        $clientSocketFile->unlink();

        echo "Client exits\n";
    }
}