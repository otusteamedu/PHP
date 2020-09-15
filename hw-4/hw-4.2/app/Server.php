<?php

namespace App;

final class Server implements SocketAppContract
{
    private $socket;

    public function __construct(string $host, int $port)
    {
        $this->initSocket($host, $port);
    }

    public function listen()
    {
        do {
            $this->socket->accept();

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
        echo "Init socket";
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

    public function run()
    {
        $this->listen();
    }

}