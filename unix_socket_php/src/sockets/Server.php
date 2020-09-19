<?php

namespace sockets;


final class Server
{
    private Socket $socket;

    public function __construct(string $host, int $port)
    {
        $this->initSocket($host, $port);
    }

    public function listen()
    {
        $this->socket->accept();

        do {
            $message = $this->socket->readFromAccepted();

            if ($message === 'quit') {
                break;
            }
            echo "Client says:\t" . $message . "\n\n";

            echo "Enter Reply:\t";
            $reply = $this->readline();
            $this->socket->writeToAccepted($reply);
        } while (true);

        $this->socket->close();
    }

    private function initSocket(string $host, int $port): void
    {
        $this->socket = new Socket($host, $port);
        $this->socket->clearOldSocket();
        $this->socket->create();
        $this->socket->bind();
        $this->socket->listen();
    }

    private function readline(): string
    {
        return rtrim(fgets(STDIN));
    }

}