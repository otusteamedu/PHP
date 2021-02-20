<?php


namespace App\Sockets;


class Client
{
    private Socket $socket;

    public function __construct(string $path, int $port)
    {

        $this->initSocket($path, $port);
    }

    public function connect()
    {
        while (true) {
            $this->socket->create()->connect();
            echo 'Enter message:';
            $message = rtrim(fgets(STDIN));
            $this->socket->write($message);
            if ($message === Server::EXIT_COMMAND) {
                echo "Server closed the connection\n";
                break;
            }
            echo 'Server: ' . $this->socket->read() . "\n";
        }
    }

    private function initSocket(string $path, int $port)
    {
        $this->socket = (new Socket($path, $port));
    }
}