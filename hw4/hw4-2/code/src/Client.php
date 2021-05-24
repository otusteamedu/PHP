<?php
namespace Src;

class Client
{
    private Socket $socket;

    public function __construct(string $host, int $port)
    {
        $this->socket = new Socket($host, $port);
        $this->socket->create();
        $this->socket->connect();
    }

    public function waitForMessage()
    {
        echo 'Enter Message:';
        $this->writeMessage($this->readline());
    }

    private function writeMessage(string $message)
    {
        $this->socket->write($message);
        $this->getResponse();
    }

    private function readline(): string
    {
        return rtrim(fgets(STDIN));
    }

    private function getResponse()
    {
        echo "Server response with: " . $this->socket->read() . PHP_EOL;
    }
}