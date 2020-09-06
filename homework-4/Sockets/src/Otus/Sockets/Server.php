<?php

namespace Otus\Sockets;

final class Server
{
    private Socket $socket;

    public function __construct(string $host, int $port)
    {
        $this->initSocket($host, $port);
    }

    public function run(): void
    {
        echo 'Waiting for client...', PHP_EOL;
        $this->socket->accept();
        echo 'Client accepted.', PHP_EOL;

        do {
            $message = $this->socket->readFromAccepted();

            echo "Client Says:\t", $message, PHP_EOL;
            echo "Enter Reply:\t";

            $reply = $this->readline();

            if ($reply === 'quit') {
                break;
            }

            $this->socket->writeToAccepted($reply);
        } while (true);

        $this->socket->close();
    }

    private function initSocket(string $host, int $port): void
    {
        $this->socket = Socket::make($host, $port)
                              ->clearSocketHost()
                              ->create()
                              ->bind()
                              ->listen();
    }

    private function readline(): string
    {
        return rtrim(fgets(STDIN));
    }
}
