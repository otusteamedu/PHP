<?php


namespace Otus\Socket;


class Client
{
    private Socket $socket;

    public function __construct(string $host, int $port)
    {
        $this->init($host, $port);
    }

    private function init(string $host, int $port): void
    {
        $this->socket = new Socket($host, $port);
        $this->socket->create(); // To connect with server socket
        $this->socket->connect();
    }

    public function waitingForMessage(): void
    {
        $this->setMessage($this->readline());
    }

    private function setMessage($message): void
    {
        $this->socket->writeToSocket($message);
    }

    private function readline(): string
    {
        return rtrim(fgets(STDIN));
    }

    public function waitingForResponse()
    {
        echo "Server says:" . PHP_EOL . $this->socket->read() . PHP_EOL;
    }
}