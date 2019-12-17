<?php

declare(strict_types=1);

use Socket\Socket;

class App
{
    /**
     * @var Socket
     */
    private Socket $socket;

    /**
     * @var string
     */
    private string $serverSocketAddress;

    /**
     * @var string
     */
    private string $clientSocketAddress;

    public function __construct(Socket $socket, string $clientSocketAddress, string $serverSocketAddress)
    {
        $this->socket = $socket;
        $this->clientSocketAddress = $clientSocketAddress;
        $this->serverSocketAddress = $serverSocketAddress;
    }

    public function send(?string $message): void
    {
        $this->socket->bind($this->clientSocketAddress);

        $message ??= 'Message';
        $len = strlen($message);
        $this->socket->send($message, $len, $this->serverSocketAddress);
        echo "Sent \"$message\" to {$this->serverSocketAddress}\n";

        $buf = '';
        $from = '';
        $this->socket->listen($buf, $from);
        echo "Received \"$buf\" from $from\n";

        $this->socket->close();
        echo "Client exits\n\n";
    }
}