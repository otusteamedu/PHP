<?php


namespace Penguin\Sockets;


class Socket extends AbstractSocket
{
    protected string $host;
    protected int $port;

    public function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;

        //$this->clearHost();

        if (($this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0)) === false) {
            throw new \Exception($this->errorMessage("Socket create error"));
        }
    }

    public function bind()
    {
        if (socket_bind($this->socket, $this->host, $this->port) === false) {
            throw new \Exception($this->errorMessage("Socket bind error"));
        }
    }

    public function listen(int $backlog = 2)
    {
        if (socket_listen($this->socket, $backlog) === false) {
            throw new \Exception($this->errorMessage("Socket listen error"));
        }
    }

    public function connect()
    {
        if (socket_connect($this->socket, $this->host, $this->port) === false) {
            throw new \Exception($this->errorMessage("Socket connect error"));
        }
    }

    public function accept()
    {
        if (($socketAccept = socket_accept($this->socket)) === false) {
            throw new \Exception($this->errorMessage("Socket accept error"));
        }

        return new AcceptSocket($socketAccept);
    }
}