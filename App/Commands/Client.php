<?php

namespace App\Commands;

class Client extends Command
{
    public function getName(): string
    {
        return 'client';
    }

    public function init($arguments = []): void
    {
        $path = (string)current($arguments);
        $port = (int)next($arguments);
        (new \App\Sockets\Client(
            !empty($path) ? $path : getenv('SOCKET_PATH'),
            $port > 0 ? $port : getenv('SOCKET_PORT')
        ))->connect();
    }
}