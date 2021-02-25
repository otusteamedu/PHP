<?php

namespace App\Console\Commands;


use App\Console\CommandContract;
use App\Sockets\Server;

class ClientCommand implements CommandContract
{

    private $path, $port;

    public function __construct(array $arguments = [])
    {
        $this->path = (string)current($arguments);
        $this->port = (int)next($arguments);
    }

    public function handle()
    {
        (new Server(
            !empty($this->path) ? $this->path : getenv('SOCKET_PATH'),
            $this->port > 0 ? $this->port : getenv('SOCKET_PORT')
        ))->listen();
    }
}