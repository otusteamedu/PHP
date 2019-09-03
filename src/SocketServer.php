<?php

namespace APankov;
class SocketServer extends Socket
{
    private $res;
    protected $socket;

    public function __construct(String $host, Int $port)
    {
        $this->res = socket_create(AF_INET, SOCK_STREAM, 0);
        if ($this->res) {
            socket_bind($this->res, $host, $port);
            socket_listen($this->res, 1);
            $this->socket = socket_accept($this->res);
        } else {
            die($this->getLastError());
        }
    }

    public function getLastError()
    {
        return socket_strerror(socket_last_error($this->res));
    }

    public function __destruct()
    {
        socket_close($this->res);
        socket_close($this->socket);
    }
}