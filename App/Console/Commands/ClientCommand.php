<?php

namespace App\Console\Commands;


class ClientCommand extends SocketCommand
{

    protected $signature = 'socket:client {path} {port} {domain}';

    public function handle(): void
    {
        $this->addArgument('type', null, '', self::TYPE_CLIENT);
        parent::handle();
    }
}