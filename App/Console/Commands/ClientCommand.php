<?php

namespace App\Console\Commands;


use App\Console\CommandContract;
use App\Sockets\Client;
use App\Sockets\Server;
use App\Sockets\Socket;
use App\Sockets\SocketConfig;
use App\Sockets\UnixSocket;

class ClientCommand extends SocketCommand
{

    public function __construct(array $arguments = [])
    {
        array_unshift($arguments, SocketCommand::TYPE_CLIENT);
        parent::__construct($arguments);
    }
}