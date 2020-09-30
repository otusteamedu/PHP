<?php

use src\Exception\CanNotCreateSocketException;
use src\Exception\SocketsException;

class SocketClient
{
    private $socket;
    private $connect;
    private string $host;
    private int $port;

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

    public function clearOldSocket(): void
    {
        if (file_exists($this->host)) {
            unlink($this->host);
        }
    }

    public function connect(): void
    {
        $this->connect = socket_connect($this->socket, $this->host, $this->port);
        if ($this->connect === false) {
            throw new CanNotCreateSocketException();
        }
    }

    public function writeToSocket($socket, string $message): void
    {
        socket_write($socket, $message, strlen($message));
    }
}