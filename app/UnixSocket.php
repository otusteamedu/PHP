<?php

namespace App;

use App\Contracts\Transport;

class UnixSocket implements Transport
{
    private $socket;
    private $socketFile;

    public function __construct($socketFile)
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        $this->socketFile = $socketFile;
    }

    public function read(): string
    {
        return socket_read($this->socket, 1000);
    }

    public function write(string $text)
    {
        socket_write($this->socket, $text);
    }

    public function connect()
    {
        socket_connect($this->socket, $this->socketFile);

        socket_set_nonblock($this->socket);
    }

    public function serve()
    {
        if (file_exists($this->socketFile)) {
            unlink($this->socketFile);
        }

        socket_bind($this->socket, $this->socketFile);

        socket_listen($this->socket);

        $connection = socket_accept($this->socket);

        $this->socket = $connection;

        socket_set_nonblock($this->socket);
    }
}
