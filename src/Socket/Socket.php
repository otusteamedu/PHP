<?php

namespace App\Socket;

use App\Socket\Exceptions\CanNotCreateSocketException;
use App\Socket\Exceptions\SocketException;

final class Socket
{
    private $socket;
    private $acceptedSocket;
    private $connect;
    private $bind;
    private string $socketFile;
    private int $maxConnections = 5;

    /**
     * Socket constructor.
     * @param $socketFile
     */
    public function __construct($socketFile)
    {
        if (!$socketFile) {
            throw new CanNotCreateSocketException('Socket file required');
        }

        $this->socketFile = $socketFile;
    }


    public function create(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$this->socket) {
            throw new CanNotCreateSocketException();
        }
    }

    public function bind(): void
    {
        $this->bind = socket_bind($this->socket, $this->socketFile);
        if (false === $this->bind) {
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

    public function accept()
    {
        $this->acceptedSocket = socket_accept($this->socket);
        if ($this->acceptedSocket === false) {
            throw new SocketException();
        }
    }

    public function connect(): void
    {
        $this->connect = socket_connect($this->socket, $this->socketFile);
        if ($this->connect === false) {
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

    public function read(): ?string
    {
        return $this->readFromSocket($this->socket);
    }

    public function readFromAccepted(): ?string
    {
        return $this->readFromSocket($this->acceptedSocket);
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
        if (file_exists($this->socketFile)) {
            unlink($this->socketFile);
        }
    }

    private function readFromSocket($socket): ?string
    {
        if (false === ($buf = socket_read($socket, 1024))) {
            throw new SocketException();
        }

        $buf = trim($buf);

        if (!$buf) {
            return null;
        }

        return $buf;
    }


    private function writeToSocket($socket, string $message): void
    {
        socket_write($socket, $message, strlen($message));
    }
}

