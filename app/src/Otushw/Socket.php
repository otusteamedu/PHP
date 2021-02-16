<?php

namespace Otushw;

use Otushw\Exception\SocketException;

/**
 * Class Socket
 *
 * @package Otushw
 */
class Socket implements CommunicationInterface
{

    public $socket;

    private $accpetedSocket;

    /**
     * @var string
     */
    public string $pathSocket;

    /**
     * @var string
     */
    public string $portSocket;

    /**
     * Socket constructor.
     */
    public function __construct()
    {
        $this->pathSocket = $_ENV['socket']['path'];
        $this->portSocket = $_ENV['socket']['port'];

        $this->create();
    }

    /**
     *
     */
    public function __destruct()
    {
        socket_shutdown($this->socket, 2);
        socket_close($this->socket);
    }

    /**
     * @throws SocketException
     */
    private function create(): void
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($socket == false) {
            throw new SocketException("Can't create socket");
        }
        $this->socket = $socket;
    }

    /**
     *
     */
    public function prepareConnection(): void
    {
        $this->removeSocketFile();

        $this->bind();
        $this->listen();
    }

    /**
     * @throws SocketException
     */
    private function bind(): void
    {
        if (!socket_bind($this->socket, $this->pathSocket, $this->portSocket)) {
            throw new SocketException("Can't bind socket");
        }
    }

    /**
     * @throws SocketException
     */
    private function listen(): void
    {
        if (!socket_listen($this->socket, 0)) {
            throw new SocketException("Can't connect socket");
        }
    }

    /**
     *
     */
    public function connectToReadyConnection(): void
    {
        $this->connect();
    }

    /**
     * @throws SocketException
     */
    private function connect(): void
    {
        if (!socket_connect($this->socket, $this->pathSocket, $this->portSocket)) {
            throw new SocketException("Can't connect socket");
        }
    }

    /**
     * @return string
     */
    public function recieve(): string
    {
        $this->socketAccept();
        return $this->socketRead($this->accpetedSocket);
    }

    /**
     * @throws SocketException
     */
    private function socketAccept(): void
    {
        $accpetedSocket = socket_accept($this->socket);
        if (empty($accpetedSocket)) {
            throw new SocketException("Can't accept socket");
        }
        $this->accpetedSocket = $accpetedSocket;
    }

    /**
     * @param $socket
     *
     * @return
     * @throws SocketException
     */
    private function socketRead($socket): string
    {
        $raw = socket_read($socket, 1024);
        if ($raw === false) {
            throw new SocketException("Can't read socket");
        }
        return $raw;
    }

    /**
     * @param string $raw
     *
     * @throws SocketException
     */
    public function send(string $raw): void
    {
        $this->socketWrite($this->socket, $raw);
    }

    /**
     * @param $socket
     * @param string $message
     *
     * @throws SocketException
     */
    private function socketWrite($socket, string $message): void
    {
        $result = socket_write(
            $socket,
            $message,
            strlen($message)
        );
        if ($result === false) {
            throw new SocketException("Can't write in socket");
        }
    }

    /**
     *
     */
    public function disconnectConnection(): void
    {
        $this->removeSocketFile();
    }

    /**
     *
     */
    private function removeSocketFile(): void
    {
        if (file_exists($this->pathSocket)) {
            unlink($this->pathSocket);
        }
    }
}