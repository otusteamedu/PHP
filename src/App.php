<?php

namespace App;

class App
{
    private string $type;

    public function __construct(string $type)
    {
        $this->type = strtolower($type);
    }

    public function run()
    {
        $this->getInstance()->run();
    }

    /**
     * @return Server|Client object
     */
    private function getInstance(): object
    {
        switch ($this->type) {
            case 'server':
                return new Server($_ENV['SOCKET_HOST'], $_ENV['SOCKET_PORT']);
            case 'client':
                return new Client($_ENV['SOCKET_HOST'], $_ENV['SOCKET_PORT']);
            default:
                throw new \InvalidArgumentException('Invalid instance type. Instance should be server either client');
        }
    }
}
