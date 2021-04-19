<?php

namespace App\Sockets;

use App\Exceptions\SocketsException;

class Socket
{
    /**
     * @var resource|Socket|false
     */
    protected $socket;

    /**
     * @var resource|Socket|false
     */
    protected $acceptedSocket;

    /**
     * @var bool
     */
    protected bool $connect;

    /**
     * @var bool
     */
    protected bool $bind;

    /**
     * @var string
     */
    protected string $host;

    /**
     * @var int
     */
    protected int $port;

    /**
     * @var int
     */
    protected int $maxConnections = 5;

    /**
     * Socket constructor.
     *
     * @param string $host
     * @param int $port
     *
     * @throws SocketsException
     */
    public function __construct(string $host, int $port)
    {
        if (!$host) {
            throw new SocketsException('Host is required');
        }
        if (!$port) {
            throw new SocketsException('Port is required');
        }
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * @param string $message
     */
    public function write(string $message): void
    {
        $this->writeToSocket($this->socket, $message);
    }

    /**
     * @param string $message
     */
    public function writeToAccepted(string $message): void
    {
        $this->writeToSocket($this->acceptedSocket, $message);
    }

    /**
     * @return void
     */
    public function clearOldSocket(): void
    {
        if (file_exists($this->host)) {
            unlink($this->host);
        }
    }

    /**
     * @throws SocketsException
     */
    public function create(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($this->socket === false) {
            throw new SocketsException('Cannot create socket!');
        }
    }

    /**
     * @throws SocketsException
     */
    public function bind(): void
    {
        $this->bind = socket_bind($this->socket, $this->host, $this->port);
        if ($this->bind === false) {
            throw new SocketsException("Cannot bind to socket!");
        }
    }

    /**
     * @throws SocketsException
     */
    public function listen(): void
    {
        $this->bind = socket_listen($this->socket, $this->maxConnections);
        if ($this->bind === false) {
            throw new SocketsException("Cannot listen to socket!");
        }
    }

    /**
     * @throws SocketsException
     */
    public function accept()
    {
        $this->acceptedSocket = socket_accept($this->socket);
        if ($this->acceptedSocket === false) {
            throw new SocketsException();
        }
    }

    /**
     * @return string|null
     *
     * @throws SocketsException
     */
    public function read(): ?string
    {
        return $this->readFromSocket($this->socket);
    }

    /**
     * @return string|null
     *
     * @throws SocketsException
     */
    public function readFromAccepted(): ?string
    {
        return $this->readFromSocket($this->acceptedSocket);
    }

    /**
     * @throws SocketsException
     */
    public function connect(): void
    {
        $this->connect = socket_connect($this->socket, $this->host, $this->port);
        if ($this->connect === false) {
            throw new SocketsException("Cannot connect to socket!");
        }
    }

    /**
     * @return void
     */
    public function close(): void
    {
        if (!$this->socket) {
            return;
        }
        socket_close($this->socket);
    }

    /**
     * @param $socket
     * @param string $message
     */
    protected function writeToSocket($socket, string $message): void
    {
        socket_write($socket, $message, strlen($message));
    }

    /**
     * @param $socket
     *
     * @return string|null
     *
     * @throws SocketsException
     */
    protected function readFromSocket($socket): ?string
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
