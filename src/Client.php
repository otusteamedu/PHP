<?php

namespace App;

class Client
{
    private Socket $socket;

    public function __construct(string $host, int $port = 0)
    {
        $this->socket = new Socket($host, $port);
        $this->socket->create();
        $this->socket->connect();
    }

    public function run()
    {
        echo 'Enter Message: ';
        $this->message($this->readline());
    }

    private function message(string $message)
    {
        $this->socket->write($message);
        $this->waitingResponse();
    }

    private function readline(): string
    {
        return rtrim(fgets(STDIN));
    }

    private function waitingResponse()
    {
        echo 'Server response: ' . $this->socket->read() . PHP_EOL;
    }
}
