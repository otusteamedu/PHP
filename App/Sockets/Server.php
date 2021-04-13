<?php

namespace App\Sockets;

use App\Sockets\Interfaces\iSocketServer;

class Server
{

    private iSocketServer $socket;

    public const EXIT_COMMAND = 'exit';

    public function __construct(iSocketServer $socket)
    {
        $this->socket = $socket;
        $this->initSocket();
    }

    public function listen()
    {
        echo "Waiting for client...\n";
        $this->socket->accept();
        while (true) {
            $message = $this->socket->accepted()->read(1024, PHP_BINARY_READ);
            if ($message === self::EXIT_COMMAND) {
                break;
            }
            echo "Client: $message\n";
            echo "Reply:";
            $this->socket->accepted()->write(rtrim(fgets(STDIN)));
        }
        $this->socket->close();
    }

    private function initSocket(): void
    {
        $this->socket
            ->create()
            ->bind()
            ->listen();
    }


}