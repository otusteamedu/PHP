<?php

namespace APankov;
class Socket
{
    protected $socket;

    public function __construct(String $host, Int $port)
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, 0);
        if ($this->socket) {
            socket_connect($this->socket, $host, $port);
        } else {
            die($this->getLastError());
        }
    }

    public function sendMsg(String $msg)
    {
        $msg = $msg . PHP_EOL;
        return socket_write($this->socket, $msg);
    }

    public function readMsg()
    {
        $msg = '';
        while (($bite = socket_read($this->socket, 1)) != PHP_EOL) {
            $msg .= $bite;
        }
        return $msg;
    }

    public function getLastError()
    {
        return socket_strerror(socket_last_error($this->socket));
    }

    public function __destruct()
    {
        socket_close($this->socket);
    }
}