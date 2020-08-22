<?php


namespace Penguin\Sockets;


use Penguin\Helpers\ConsoleHelper;

class Client
{
    protected Socket $socket;

    public function __construct(string $host, int $port)
    {
        $this->socket = new Socket($host, $port);
    }

    public function run()
    {
        $this->socket->connect();
        echo 'Connection OK.' . PHP_EOL;

        $this->socket->write("Ping");
        echo "Server message:" . $this->socket->read(2048);

        $this->socket->close();
    }
}