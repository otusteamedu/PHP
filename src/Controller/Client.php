<?php

namespace Sergey\Otus\Controller;

use Sergey\Otus\Helper\ConfigProvider;
use Sergey\Otus\Exception\SocketException;

class Client
{
    public function execute()
    {
        if (!extension_loaded('sockets')) {
            throw new SocketException('The sockets extension is not loaded.');
        }

        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if (!$socket) {
            throw new SocketException('Unable to create AF_UNIX socket');
        }

        $clientSocketFile = ConfigProvider::getInstance()->getClientSocketFile();

        if (!socket_bind($socket, $clientSocketFile)) {
            throw new SocketException("Unable to bind to $clientSocketFile");
        }

        if (!socket_set_nonblock($socket)) {
            throw new SocketException('Unable to set nonblocking mode for socket');
        }

        $serverSocketFile = ConfigProvider::getInstance()->getServerSocketFile();
        $message = $this->getMessage();
        $bytes = strlen($message);

        $bytesSent = socket_sendto($socket, $message, $bytes, 0, $serverSocketFile);

        if ($bytesSent == -1) {
            throw new SocketException('An error occurred while sending to the socket');
        }
        elseif ($bytesSent != $bytes) {
            throw new SocketException($bytesSent . ' bytes have been sent instead of the ' . $bytes . ' bytes expected');
        }

        if (!socket_set_block($socket)) {
            throw new SocketException('Unable to set blocking mode for socket');
        }

        $message = '';
        $serverSocketFile = '';
        // will block to wait server response
        $bytesReceived = socket_recvfrom($socket, $message, 65536, 0, $serverSocketFile);
        if ($bytesReceived == -1) {
            throw new SocketException('An error occured while receiving from the socket');
        }

        echo sprintf("Server (%s) answered: \"%s\"\n", $serverSocketFile, $message);

        socket_close($socket);
        unlink($clientSocketFile);
        echo "Client exits\n";
    }

    /**
     * @return string
     */
    protected function getMessage()
    {
        $options = getopt("r:m:");

        return $options['m'] ?? '';
    }
}
