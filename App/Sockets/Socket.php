<?php

namespace App\Sockets;

use Exception;
use InvalidArgumentException;

class Socket
{
    private string $path;
    private int $port;
    private int $maxConnections = 5;

    private $sockets = [
        'base'     => false,
        'accepted' => false
    ];

    public function __construct(string $path, int $port)
    {
        if (!$path) {
            throw new InvalidArgumentException('Path [$path] is required');
        }

        if (!$port) {
            throw new InvalidArgumentException('Port [$port] is required');
        }
        $this->path = $path;
        $this->port = $port;
        if (!file_exists($path)) {
            mkdir(dirname($path));
        }
    }

    public function clearOldSocket()
    {
        if (file_exists($this->path)) {
            unlink($this->path);
        }
        return $this;
    }

    //TODO: create special exception
    public function create()
    {
        $this->sockets['base'] = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($this->sockets['base'] === false) {
            throw new Exception('Socket is not created');
        }
        return $this;
    }

    public function accept()
    {
        $this->sockets['accepted'] = socket_accept($this->sockets['base']);
        if ($this->sockets['accepted'] === false) {
            throw new Exception('Socket is not created');
        }
        return $this;
    }

    public function bind()
    {
        if (socket_bind($this->sockets['base'], $this->path, $this->port) === false) {
            throw new Exception('Socket is not created');
        }
        return $this;
    }

    public function listen()
    {
        if (socket_listen($this->sockets['base'], $this->getMaxConnections()) === false) {
            throw new Exception('Socket is not created');
        }
        return $this;
    }

    public function connect()
    {
        if (socket_connect($this->sockets['base'], $this->path, $this->port) === false) {
            throw new \Exception('Can`t connect to server`s socket');
        }
        return $this;
    }

    public function close()
    {
        if ($this->sockets['base']) {
            socket_close($this->sockets['base']);
        }
    }

    public function readFromAccepted(): ?string
    {
        return $this->readFromSocket($this->sockets['accepted']);
    }

    public function read(): ?string
    {
        return $this->readFromSocket($this->sockets['base']);
    }

    private function readFromSocket($socket): ?string
    {
        $buffer = socket_read($socket, 1024);
        if ($buffer === false) {
            throw new Exception('Cannot red from socket');
        }
        $buffer = trim($buffer);
        return $buffer === '' ? null : $buffer;
    }

    public function writeToAccepted(string $message): void
    {
        $this->writeToSocket($this->sockets['accepted'], $message);
    }

    public function write(string $message): void
    {
        $this->writeToSocket($this->sockets['base'], $message);
    }

    private function writeToSocket($socket, string $message): void
    {
        socket_write(
            $socket,
            $message,
            strlen($message)
        );
    }

    /**
     * @return int
     */
    public function getMaxConnections(): int
    {
        return $this->maxConnections;
    }

    /**
     * @param int $maxConnections
     * @return Socket
     */
    public function setMaxConnections(int $maxConnections)
    {
        $this->maxConnections = $maxConnections;
        return $this;
    }
}