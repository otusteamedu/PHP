<?php

namespace App\Commands;

use App\Services\Socket\Socket;

class Commands
{
    public function getCommand(string $command): CommandInterface
    {
        $cmd = mb_strtoupper($command[0]) . substr($command, 1);
        $class = 'App\Commands\\' . $cmd;
        $class = new $class(new Socket());

        return $class;
    }
}