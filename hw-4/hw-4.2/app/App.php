<?php


namespace App;
use App\Client;

class App
{
    private $instance;

    public function __construct(string $instance)
    {
        $class = 'App\\' . ucfirst($instance);
        $this->instance = new $class($_ENV['SOCKET_PATH'], $_ENV['SOCKET_PORT']);
    }

    public function run()
    {
        $this->instance->run();
    }
}
