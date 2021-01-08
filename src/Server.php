<?php

namespace App;

class Server
{
    private Socket $socket;

    public function __construct(string $host, int $port = 0)
    {
        $this->socket = new Socket($host, $port);
        $this->socket->clearOldSocket();
        $this->socket->create();
        $this->socket->bind();
        $this->socket->listen();
    }

    public function run()
    {
        while (true) {
            $this->socket->accept();
            $message = $this->socket->readFromAccepted();

            echo 'Received message: ' . $message . "\n";
            echo "Enter reply: ";

            $reply = $this->readline();
            $this->socket->writeToAccepted($reply);
        }
    }

    private function readline(): string
    {
        return rtrim(fgets(STDIN));
    }
}
