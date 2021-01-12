<?php

namespace App;

use App\Exception\SocketException;

class Socket
{
    private $socket;
    private $acceptedSocket;
    private $connect;
    private string $host;
    private int $port;
    private int $maxConnections = 5;

    public function __construct(string $host, int $port = 0)
    {
        $this->host = $host;
        $this->port = $port;
    }

    public function write(string $message): void
    {
        $this->writeToSocket($this->socket, $message);
    }

    public function writeToAccepted(string $message): void
    {
        $this->writeToSocket($this->acceptedSocket, $message);
    }

    public function clearOldSocket(): void
    {
        if (file_exists($this->host)) {
            unlink($this->host);
        }
    }

    public function create(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if ($this->socket === false) {
            throw new SocketException();
        }
    }

    public function accept(): void
    {
        $this->acceptedSocket = socket_accept($this->socket);

        if (false === $this->acceptedSocket) {
            throw new SocketException();
        }
    }

    public function read(): ?string
    {
        return $this->readFromSocket($this->socket);
    }

    public function readFromAccepted(): ?string
    {
        return $this->readFromSocket($this->acceptedSocket);
    }

    public function bind(): void
    {
        $bind = socket_bind($this->socket, $this->host, $this->port);

        if ($bind === false) {
            throw new SocketException();
        }
    }

    public function connect(): void
    {
        $this->connect = socket_connect($this->socket, $this->host, $this->port);

        if ($this->connect === false) {
            throw new SocketException();
        }
    }

    public function listen(): void
    {
        $listen = socket_listen($this->socket, $this->maxConnections);

        if ($listen === false) {
            throw new SocketException();
        }
    }

    private function writeToSocket($socket, string $message): void
    {
        socket_write(
            $socket,
            $message,
            strlen($message)
        );
    }

    private function readFromSocket($socket): ?string
    {
        if (false === ($buf = socket_read($socket, 1024))) {
            throw new SocketException();
        }

        if (!$buf = trim($buf)) {
            return null;
        }

        return trim($buf);
    }
}
