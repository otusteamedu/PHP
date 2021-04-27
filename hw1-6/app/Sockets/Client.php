<?php

namespace App\Sockets;

use App\Exceptions\SocketsException;

class Client
{
    /**
     * @var Socket
     */
    protected Socket $socket;

    /**
     * Client constructor.
     *
     * @param string $host
     * @param int $port
     *
     * @throws SocketsException
     */
    public function __construct(string $host, int $port)
    {
        $this->initSocket($host, $port);
    }

    /**
     * @throws SocketsException
     */
    public function waitForMessage()
    {
        echo 'Enter Message:';
        $this->message($this->readline());
    }

    /**
     * @param string $message
     *
     * @throws SocketsException
     */
    protected function message(string $message)
    {
        $this->socket->write($message);
        $this->waitingResponse();
    }

    /**
     * @param string $host
     * @param int $port
     *
     * @throws SocketsException
     */
    protected function initSocket(string $host, int $port): void
    {
        $this->socket = new Socket($host, $port);
        $this->socket->create();
        $this->socket->connect();
    }

    /**
     * @return string
     */
    protected function readline(): string
    {
        return rtrim(fgets(STDIN));
    }

    /**
     * @throws SocketsException
     */
    protected function waitingResponse()
    {
        echo "Server says:\t" . $this->socket->read() . "\n";
    }
}
