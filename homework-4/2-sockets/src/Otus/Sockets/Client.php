<?php

namespace Otus\Sockets;

final class Client
{
    private Socket $socket;

    public function __construct(string $host, int $port)
    {
        $this->initSocket($host, $port);
    }

    public function run(): void
    {
        do {
            echo "Enter Message:\t";

            $message = $this->readline();

            if ($message === 'quit') {
                break;
            }

            $this->message($message);
        } while (true);
    }

    private function message(string $message): void
    {
        $this->socket->write($message);
        $this->waitingResponse();
    }

    private function initSocket(string $host, int $port): void
    {
        $this->socket = Socket::make($host, $port)
                              ->create()
                              ->connect();
    }

    private function readline(): string
    {
        return rtrim(fgets(STDIN));
    }

    private function waitingResponse(): void
    {
        echo "Server says:\t", $this->socket->read(), PHP_EOL;
    }
}
