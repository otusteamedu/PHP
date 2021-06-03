<?php


namespace App\Console\Commands;


use App\Console\CommandContract;
use App\Sockets\Server;
use App\Sockets\Socket;
use App\Sockets\SocketConfig;
use App\Sockets\UnixSocket;

class ServerCommand extends SocketCommand
{

    protected $signature = 'socket:server {path?} {port?} {domain?}';

    public function handle(): void
    {
        $this->addArgument('type', null, '', self::TYPE_SERVER);
        parent::handle();
    }
}