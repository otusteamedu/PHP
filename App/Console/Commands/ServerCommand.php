<?php


namespace App\Console\Commands;


class ServerCommand extends SocketCommand
{

    protected $signature = 'socket:server {path?} {port?} {domain?}';

    public function handle(): void
    {
        $this->addArgument('type', null, '', self::TYPE_SERVER);
        parent::handle();
    }
}