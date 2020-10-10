<?php

use Otus\Exception\SocketsException;

class SocketServer
{
    private $socket;
    private $acceptedSocket;
    private $connect;
    private $bind;
    private string $host;
    private int $port;
    private int $maxConnections = 5;

    public function __construct(string $host, int $port)
    {
        if (!$host) {
            throw new CanNotCreateSocketException('Укажите адрес подключения');
        }
        if (!$port) {
            throw new CanNotCreateSocketException('Укажите порт для подключения');
        }
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
            throw new CanNotCreateSocketException();
        }
    }

    public function accept()
    {
        $this->acceptedSocket = socket_accept($this->socket);
        if ($this->acceptedSocket === false) {
            throw new SocketsException();
        }
    }

    public function read(): ?string
    {
        return $this->readFromSocket($this->socket);
    }

    public function readFromAccepted()
    {
        return $this->readFromSocket($this->acceptedSocket);
    }

    public function bind(): void
    {
        $this->bind = socket_bind($this->socket, $this->host, $this->port);
        if ($this->connect === false) {
            throw new CanNotCreateSocketException();
        }
    }

    public function connect(): void
    {
        $this->connect = socket_connect($this->socket, $this->host, $this->port);
        if ($this->connect === false) {
            throw new CanNotCreateSocketException();
        }
    }

    public function listen(): void
    {
        $this->bind = socket_listen($this->socket, $this->maxConnections);
        if ($this->bind === false) {
            throw new CanNotCreateSocketException();
        }
    }

    public function close(): void
    {
        if (!$this->socket) {
            return;
        }
        socket_close($this->socket);
    }

    public function writeToSocket($socket, string $message): void
    {
        socket_write($socket, $message, strlen($message));
    }

    private function readFromSocket($socket): ?string
    {
        if (false === ($buf = socket_read($socket, 1024))) {
            throw new SocketsException();
        }
        if (!$buf = trim($buf)) {
            return null;
        }
        return trim($buf);
    }
}