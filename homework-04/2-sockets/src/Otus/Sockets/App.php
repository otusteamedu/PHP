<?php

namespace Otus\Sockets;

use Otus\Sockets\Exceptions\SocketsException;
use Otus\Sockets\Exceptions\UnsupportedApplicationTypeException;

class App
{
    private string $type;

    private string $host;

    private int $port;

    public function __construct()
    {
        $this->type = $_SERVER['argv'][1] ?? '';
        $this->host = $_ENV['SOCKET_HOST'];
        $this->port = $_ENV['SOCKET_PORT'];
    }

    public function run(): void
    {
        switch ($this->type) {
            case 'server':
                $this->createSocketServer();
                break;
            case 'client':
                $this->createSocketClient();
                break;
            default:
                throw new UnsupportedApplicationTypeException();
        }
    }

    private function createSocketServer(): void
    {
        try {
            $server = new Server($this->host, $this->port);
            $server->run();
        } catch (SocketsException $exception) {
            echo 'Can not create socket server: ', $exception->getMessage(), PHP_EOL;
        }
    }

    private function createSocketClient(): void
    {
        try {
            $client = new Client($this->host, $this->port);
            $client->run();
        } catch (SocketsException $exception) {
            echo 'Can not connect to socket server:', $exception->getMessage(), PHP_EOL;
        }
    }
}
