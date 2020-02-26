<?php

namespace Sergey\Otus\Controller;

use Sergey\Otus\Exception\SocketException;
use Sergey\Otus\Helper\ConfigProvider;

class Server
{
	public function execute()
    {
        if (!extension_loaded('sockets')) {
            throw new SocketException('The sockets extension is not loaded.');
        }

        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if (!$socket) {
            throw new SocketException('Unable to create socket', socket_last_error());
        }

        $serverSocketFile = ConfigProvider::getInstance()->getServerSocketFile();

        if (!socket_bind($socket, $serverSocketFile)) {
            throw new SocketException("Unable to bind to $serverSocketFile", socket_last_error());
        }

        while(true)
        {
            if (!socket_set_block($socket)) {
                throw new SocketException('Unable to set blocking mode for socket');
            }

            $inputMessage = '';
            $clientSocketFile = '';
            echo "Ready to receive...\n";

            $bytesReceived = socket_recvfrom($socket, $inputMessage, 65536, 0, $clientSocketFile);
            if ($bytesReceived == -1) {
                throw new SocketException('An error occured while receiving from the socket');
            }

            echo sprintf("Received %s from %s\n", $inputMessage, $clientSocketFile);

            $answerMessage = $this->getMessage($inputMessage);

            if (!socket_set_nonblock($socket)) {
                throw new SocketException('Unable to set nonblocking mode for socket');
            }

            $bytes = strlen($answerMessage);
            $bytesSent = socket_sendto($socket, $answerMessage, $bytes, 0, $clientSocketFile);

            if ($bytesSent == -1) {
                throw new SocketException('An error occured while sending to the socket');
            }
            elseif ($bytesSent != $bytes) {
                throw new SocketException($bytesSent . ' bytes have been sent instead of the ' . $bytes . ' bytes expected');
            }

            echo "Request processed\n";

        }
	}

    /**
     * @param string $message
     * @return string|null
     */
    protected function getMessage($message)
    {
        if ($message == 'ping') {
            return 'pong';
        }

        return 'Invalid command was sent to server';
    }
}
