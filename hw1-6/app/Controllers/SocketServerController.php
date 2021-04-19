<?php

namespace App\Controllers;

use App\Sockets\Server;
use App\Exceptions\SocketsException;

class SocketServerController
{
    /**
     * @throws SocketsException
     */
    public function index()
    {
        $server = new Server($_ENV['SOCKET_PATH'],$_ENV['SOCKET_PORT']);

        $server->listen();
    }
}
