<?php

namespace App\Sockets;

class Server
{

    private Socket $socket;

    public const EXIT_COMMAND = 'exit';

    public function __construct(string $path, int $port)
    {
        $this->initSocket($path, $port);
    }

    public function listen()
    {
        echo "Waiting for client...\n";
        while (true) {
            $message = $this->socket->accept()->readFromAccepted();
            if ($message === self::EXIT_COMMAND) {
                break;
            }
            echo "Client: $message\n";
            echo "Reply:";
            $this->socket->writeToAccepted(rtrim(fgets(STDIN)));
        }
        $this->socket->close();
    }

    private function initSocket(string $path, int $port): void
    {
        $this->socket = new Socket($path, $port);
        $this->socket
            ->clearOldSocket()
            ->create()
            ->bind()
            ->listen();
    }


}