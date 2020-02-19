<?php

namespace App;

final class Client
{
    private Socket $socket;

    /**
     * @param Socket $socket
     */
    public function __construct(Socket $socket)
    {
        $this->socket = $socket;
    }

    /**
     * @param string $message
     * @return string
     * @throws SocketException
     */
    public function send(string $message): string
    {
        $buf = '';
        $from = '';
        $this->socket
            ->sendTo($message, getenv('SOCKET_SERVER'))
            ->recvFrom($buf, $from);
        return $buf;
    }
}
