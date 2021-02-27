<?php

namespace App\Core;

use App\Sockets\Client;
use App\Sockets\Exceptions\SocketsException;
use App\Sockets\Server;

class App
{
    private array $argv;

    private const SOCKET_SERVER = 'server';
    private const SOCKET_CLIENT = 'client';

    private const ALLOWED_ARGUMENTS = [
        self::SOCKET_CLIENT,
        self::SOCKET_SERVER,
    ];

    public function __construct(array $argv)
    {
        $this->argv = $argv;
    }

    public function run()
    {
        if(false === $this->checkRequriedArgument()){
            throw new \Exception('Invalid argument passed');
        }

        $type = $this->argv[1];

        switch ($type){
            case self::SOCKET_SERVER:
                return $this->runServer();
            case self::SOCKET_CLIENT:
                return $this->runClient();
        }
    }

    private function checkRequriedArgument()
    {
        return isset($this->argv[1]) && in_array($this->argv[1], self::ALLOWED_ARGUMENTS, true);
    }

    private function runClient()
    {
        try {
            $client = new Client(
                $_ENV['SOCKET_PATH'],
                $_ENV['SOCKET_PORT'],
            );

            $client->waitForMessage();

        } catch (SocketsException $e) {
            echo 'Can not connect to server', PHP_EOL;
        }
    }

    private function runServer()
    {
        try {
            $server = new Server(
                $_ENV['SOCKET_PATH'],
                $_ENV['SOCKET_PORT'],
            );

            $server->listen();

        } catch (SocketsException $e) {
            echo 'SocketsException', PHP_EOL;
        }
    }
}