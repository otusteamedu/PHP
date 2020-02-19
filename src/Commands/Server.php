<?php

namespace App\Commands;

use App\Services\Socket;

class Server implements Command
{
    public function getName(): string
    {
        return 'Server';
    }

    public function process(): void
    {

    }
}
