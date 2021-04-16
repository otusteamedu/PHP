<?php


namespace App\Console\Commands;


use App\Console\CommandContract;
use App\Sockets\Server;
use App\Sockets\Socket;
use App\Sockets\SocketConfig;
use App\Sockets\UnixSocket;

class ServerCommand extends SocketCommand
{

    public function __construct(array $arguments = [])
    {
        array_unshift($arguments, SocketCommand::TYPE_SERVER);
        parent::__construct($arguments);
    }
}