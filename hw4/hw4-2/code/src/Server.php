<?php
namespace Src;

class Server
{
    private Socket $socket;

    public function __construct(string $host, int $port)
    {
        $this->socket = new Socket($host, $port);
        $this->socket->clearOldSocket();
        $this->socket->create();
        $this->socket->bind();
        $this->socket->listen();
    }

    public function listen()
    {
        echo 'Server is listening' . PHP_EOL;

        while (true) {
            $this->socket->accept();

            $message = $this->socket->readFromAccepted();

            if ($message === 'quit') {
                break;
            }

            echo "Client says:\t" . $message . "\n\n";

            echo "Enter Reply:\t";
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
