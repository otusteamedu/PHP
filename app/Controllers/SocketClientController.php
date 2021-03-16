<?php

namespace App\Controllers;

use App\Sockets\Client;
use App\Exceptions\SocketsException;

class SocketClientController
{
    /**
     * @throws SocketsException
     */
    public function index()
    {
        $client = new Client($_ENV['SOCKET_PATH'], $_ENV['SOCKET_PORT']);

        $client->waitForMessage();
    }
}
