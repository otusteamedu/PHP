<?php


namespace App\Commands;


class Server extends Command
{

    public function getName(): string
    {
        return 'server';
    }

    public function init($arguments = []): void
    {
        $path = (string)current($arguments);
        $port = (int)next($arguments);
        (new \App\Sockets\Server(
            !empty($path) ? $path : getenv('SOCKET_PATH'),
            $port > 0 ? $port : getenv('SOCKET_PORT')
        ))->listen();
    }
}