<?php


namespace Otus\Socket;

use PHPUnit\Util\Exception;

class Socket
{
    private $socket;
    private $acceptedSocket;
    private string $host;
    private int $port;
    private int $maxConnections = 5;
    private const SOCKET_READ_LENGTH = 1024;

    function __construct(string $host, int $port)
    {
        if (!extension_loaded('sockets')) {
            throw new Exception('The sockets extension is not loaded.');
        }

        if (!$host) {
            throw new Exception('Host is required');
        }
        if (!$port) {
            throw new Exception('Port is required');
        }

        $this->host = $host;
        $this->port = $port;
    }

    public function create(): void
    {
        // create unix udp socket
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$this->socket)
            throw new Exception('Unable to create AF_UNIX socket');
    }

    public function bind(): void
    {
        if(!socket_bind($this->socket, $this->host, $this->port))
        {
            throw new Exception('Can\'t bind the socket');
        }
    }

    public function listen(): void
    {
        if (!socket_listen($this->socket, $this->maxConnections)) {
            throw new Exception('Can\'t listen the socket');
        }
    }

    public function connect(): void
    {
        if (!socket_connect($this->socket, $this->host, $this->port)) {
            throw new Exception('Can\'t connect the socket' . PHP_EOL . socket_strerror(socket_last_error()));
        }
    }

    public function accept(): void
    {
        $this->acceptedSocket = socket_accept($this->socket);
        if (!$this->acceptedSocket) {
            throw new Exception('Can\'t accept the socket');
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

    private function readFromSocket($socket): ?string
    {
        if (!$buf = socket_read($socket, self::SOCKET_READ_LENGTH)) {
            throw new Exception('Can\'t read the socket');
        }
        if (!$buf = trim($buf)) {
            return null;
        }
        return $buf;
    }

    public function writeToAccepted(string $message): void
    {
        $this->writeToSocket($message, $this->acceptedSocket);
    }

    public function writeToSocket(string $message, $socket = null): void
    {
        if($socket === null) {
            $socket = $this->socket;
        }

        socket_write(
            $socket,
            $message,
            strlen($message)
        );
    }

    public function clear(): void
    {
        // Clear existed socket file
        if (file_exists($this->host)) {
            unlink($this->host);
        }
    }

    public function close(): void
    {
        if (!$this->socket) {
            return;
        }
        socket_close($this->socket);
    }

}