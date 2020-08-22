<?php


namespace Penguin\Sockets;


abstract class AbstractSocket
{
    protected $socket;

    public function read(int $length = 1024) : string
    {
        return trim(socket_read($this->socket, $length));
    }
    public function write(string $message) : void
    {
        socket_write($this->socket, $message, strlen($message));
    }

    public function close() : void
    {
       socket_close($this->socket);
    }

    protected function errorMessage(string $message = '') : string
    {
        return trim($message . ' ' .socket_strerror(socket_last_error($this->socket)));
    }
}