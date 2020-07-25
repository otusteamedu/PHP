<?php

namespace SayHelloApp;

class Client
{
    private $socket;
    private $socketFile;

    public function __construct($socketFile)
    {
        $this->socketFile = $socketFile;
        $this->connect();
    }


    private function connect(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        socket_connect($this->socket, $this->socketFile);
    }


    public function sendMessage(string $msg): string
    {
        socket_write($this->socket, $msg, strlen($msg));
        return socket_read($this->socket, 2048);
    }


    public function __destruct()
    {
        socket_close($this->socket);
    }

}

