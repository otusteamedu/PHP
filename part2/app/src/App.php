<?php

namespace Src;

/**
 * Class App
 *
 * @package Src
 */
class App
{
    private $role;

    /**
     * App constructor.
     *
     * @param $role
     */
    public function __construct($role)
    {
        $this->role = $role[1];
    }

    public function run()
    {
        if (!empty($this->role)) {
            if ($this->role === 'client') {
                $this->getClientSocket();
            } else {
                $this->getServerSocket();
            }
        } else {
            throw new \Exception('Socket role must be set.' . PHP_EOL);
        }
    }

    public function getClientSocket()
    {
        $app = new Client(
            $_ENV['SOCKET_PATH'],
            $_ENV['SOCKET_PORT']
        );
        $app->waitForMessage();
    }

    public function getServerSocket()
    {
        $app = new Server(
            $_ENV['SOCKET_PATH'],
            $_ENV['SOCKET_PORT']
        );
        $app->listen();
    }
}