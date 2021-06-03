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

    protected $signature = 'socket:client {path} {port} {domain}';

    public function handle(): void
    {
        $this->addArgument('type', null, '', self::TYPE_CLIENT);
        parent::handle();
    }
}