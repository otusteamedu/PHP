<?php


namespace Penguin\Sockets;


class AcceptSocket extends AbstractSocket
{
    public function __construct($socket)
    {
        $this->socket = $socket;
    }
}