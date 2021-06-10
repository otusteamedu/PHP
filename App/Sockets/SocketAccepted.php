<?php


namespace App\Sockets;



use App\Sockets\Exceptions\SocketNotAccepted;

class SocketAccepted extends AbstractSocket
{
    private $socket;

    public function __construct($socket)
    {
        $this->socket = socket_accept($socket);
        if ($this->socket === false) {
            throw new SocketNotAccepted();
        }
    }

    protected function getSocket()
    {
        return $this->socket;
    }
}