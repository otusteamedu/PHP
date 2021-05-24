<?php
namespace Src;


class Socket
{
    private $socket;
    private $acceptedSocket;
    private $connect;
    private $bind;
    private $host;
    private $port;
    private $maxConnections = 5;

    public function __construct(string $host, int $port)
    {
        if (!$host) {
            throw new \Exception('Host is required');
        } elseif (!$port) {
            throw new \Exception('Port is required');
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
        if (!$this->socket) {
            throw new \Exception('Create socket error');
        }
        socket_get_option($this->socket, SOL_SOCKET, SO_REUSEADDR);
    }

    public function accept()
    {
        $this->acceptedSocket = socket_accept($this->socket);
        if (!$this->acceptedSocket) {
            throw new \Exception('Accept socket error');
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
        if (!$this->bind) {
            throw new \Exception('Bind error');
        }
    }

    public function connect(): void
    {
        $this->connect = socket_connect($this->socket, $this->host, $this->port);
        if (!$this->connect) {
            throw new \Exception('Connect error');
        }
    }

    public function listen(): void
    {
        $this->bind = socket_listen($this->socket, $this->maxConnections);
        if (!$this->bind) {
            throw new \Exception('Listen socket error');
        }
    }

    public function close(): void
    {
        if (!$this->socket) {
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
        if (!$buf = socket_read($socket, 1024)) {
            throw new \Exception('Read socket error');
        }
        return $buf;
    }
}
