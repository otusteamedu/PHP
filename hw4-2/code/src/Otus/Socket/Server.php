<?php

namespace Otus\Socket;

class Server
{
    private Socket $socket;

    public function __construct(string $host, int $port)
    {
        $this->init($host, $port);
    }

    private function init(string $host, int $port): void
    {
        $this->socket = new Socket($host, $port);
        $this->socket->clear();
        $this->socket->create();
        $this->socket->bind();
        $this->socket->listen();
    }

    public function listen(): void
    {
        while (true) {
            echo 'Server is waiting for message from a client' . PHP_EOL;
            $this->socket->accept();

            $message = $this->socket->readFromAccepted();
            if ($message === 'quit' || $message === 'exit') {
                break;
            }

            echo 'Received message from a client: ' .PHP_EOL . $message . PHP_EOL;
            echo 'Please enter reply: ' . PHP_EOL;
            $reply = $this->readline();
            $this->socket->writeToAccepted($reply);
        }

        $this->socket->close();
    }

    private function readline(): string
    {
        return rtrim(fgets(STDIN));
    }
}