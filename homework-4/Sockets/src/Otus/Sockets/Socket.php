<?php

namespace Otus\Sockets;

use Otus\Sockets\Exceptions\CanNotCreateSocketException;
use Otus\Sockets\Exceptions\SocketsException;

final class Socket
{
    /** @var resource|false */
    private $socket;

    /** @var resource|false */
    private $acceptedSocket;

    private bool $bind;

    private string $host;

    private int $port;

    private int $maxConnections = 5;

    public function __construct(string $host, int $port)
    {
        if (! $host) {
            throw new CanNotCreateSocketException('Host is required');
        }

        if (! $port) {
            throw new CanNotCreateSocketException('Port is required');
        }

        $this->host = $host;
        $this->port = $port;
    }

    public static function make(string $host, int $port): self
    {
        return new self($host, $port);
    }

    public function create(): self
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if ($this->socket === false) {
            throw new CanNotCreateSocketException();
        }

        return $this;
    }

    public function clearSocketHost(): self
    {
        if (file_exists($this->host)) {
            unlink($this->host);
        }

        return $this;
    }

    public function bind(): self
    {
        $this->bind = socket_bind($this->socket, $this->host, $this->port);

        if ($this->bind === false) {
            throw new CanNotCreateSocketException();
        }

        return $this;
    }

    public function listen(): self
    {
        $this->bind = socket_listen($this->socket, $this->maxConnections);

        if ($this->bind === false) {
            throw new CanNotCreateSocketException();
        }

        return $this;
    }

    public function write(string $message): void
    {
        $this->writeToSocket($this->socket, $message);
    }

    public function writeToAccepted(string $message): void
    {
        $this->writeToSocket($this->acceptedSocket, $message);
    }

    public function accept(): void
    {
        $this->acceptedSocket = socket_accept($this->socket);

        if ($this->acceptedSocket === false) {
            throw new SocketsException("Can't accept socket");
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

    public function connect(): self
    {
        if (socket_connect($this->socket, $this->host, $this->port) === false) {
            throw new CanNotCreateSocketException();
        }

        return $this;
    }

    public function close(): void
    {
        if (! $this->socket) {
            return;
        }

        socket_close($this->socket);
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
            throw new SocketsException("Can't read from socket");
        }

        if (! $buf = trim($buf)) {
            return null;
        }

        return trim($buf);
    }
}
