<?php


namespace App\Sockets;


use App\Sockets\Interfaces\iSocketBase;

class Client
{
    private iSocketBase $socket;

    public function __construct(iSocketBase $socket)
    {
        $this->socket = $socket;
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
}