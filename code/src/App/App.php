<?php

namespace App;

use Socket\Client;
use Socket\Exceptions\SocketsException;
use Socket\Server;
use Exception;

class App
{
    private array $argv;

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

        if ($type === 'server') {
            $this->runServerSide();
        } elseif ($type === 'client') {
            $this->runClientSide();
        }

    }

    public function checkRequriedArgument()
    {
        return isset($this->argv[1]) && in_array($this->argv[1], ['server', 'client']);
    }

    public function runClientSide()
    {
        try {
            $client = new Client(
                $this->read('SOCKET_PATH'),
                $this->read('SOCKET_PORT')
            );

            $client->waitForMessage();

        } catch (SocketsException $e) {
            echo 'Can not connect to server', PHP_EOL;
        }
    }

    public function runServerSide()
    {
        try {
            $server = new Server(
                $this->read('SOCKET_PATH'),
                $this->read('SOCKET_PORT')
            );

            $server->listen();

        } catch (SocketsException $e) {
            echo 'SocketsException', PHP_EOL;
        }
    }

    public function read ($key)
    {
        $config = parse_ini_file('config.ini');

        if ($config === false) {
            throw new Exception('Config reading error');
        }

        return $config[$key];
    }
}