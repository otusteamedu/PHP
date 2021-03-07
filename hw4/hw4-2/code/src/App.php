<?php


namespace Src;


class App
{
    private $role;

    public function __construct($role)
    {
        $this->role = $role[1];
    }

    public function run()
    {
        if (!empty($this->role)) {
            if ($this->role == 'client') {
                $app = new Client(
                    $_ENV['SOCKET_PATH'],
                    $_ENV['SOCKET_PORT']
                );
                $app->waitForMessage();
            } else {
                $app = new Server(
                    $_ENV['SOCKET_PATH'],
                    $_ENV['SOCKET_PORT']
                );
                $app->listen();
            };
        } else {
            throw new \Exception('Socket role must be set.' . PHP_EOL);
        }
    }
}