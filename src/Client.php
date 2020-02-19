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
     * @param string $addr
     * @return string
     * @throws SocketException
     */
    public function send(string $message, string $addr): string
    {
        $buf = '';
        $from = '';
        $this->socket
            ->sendTo($message, $addr)
            ->recvFrom($buf, $from);
        return $buf;
    }
}
