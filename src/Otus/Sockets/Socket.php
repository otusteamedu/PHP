<?php

/**
 * Description of Socket.php
 * @copyright Copyright (c) eapdob
 * @author    Evgenii Poperezhay <eapdob@gmail.com>
 */

namespace Otus\Sockets;

use Otus\Sockets\Exceptions\CanNotCreateSocketException;
use Otus\Sockets\Exceptions\SocketException;

final class Socket
{
    private $socket;
    private $acceptedSocket;
    private $bind;
    private $connect;
    private string $host;
    private int $port;
    private int $maxConnections = 10;

    public function __construct(string $host, int $port)
    {
        if (!$host) {
            throw new CanNotCreateSocketException('Host is required');
        }
        if (!$port) {
            throw new CanNotCreateSocketException('Port is required');
        }
        $this->host = $host;
        $this->port = $port;
    }

    public function create(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
    }

    public function bind(): void
    {
        $this->bind = socket_bind($this->socket, $this->host, $this->port);
        if ($this->bind === false) {
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

    public function accept(): void
    {
        $this->acceptedSocket = socket_accept($this->socket);
        if ($this->acceptedSocket === false) {
            throw new SocketException();
        }
    }

    public function close(): void
    {
        if (!$this->socket) {
            return;
        }
        socket_close($this->socket);
    }

    public function clear(): void
    {
        if (file_exists($this->host)) {
            unlink($this->host);
        }
    }

    public function write($message): void
    {
        $this->writeToSocket($this->socket, $message);
    }

    public function writeToAccepted($message): void
    {
        $this->writeToSocket($this->acceptedSocket, $message);
    }

    public function read(): ?string
    {
        return $this->readFromSocket($this->socket);
    }

    public function readFromAccepted(): ?string
    {
        return $this->readFromSocket($this->acceptedSocket);
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

    private function writeToSocket($socket, string $message): void
    {
        socket_write(
            $socket,
            $message,
            strlen($message)
        );
    }
}