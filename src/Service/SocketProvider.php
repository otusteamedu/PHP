<?php

declare(strict_types=1);

namespace Service;

use Socket\Socket;

class SocketProvider
{
    public function createSocket(): Socket
    {
        return new Socket(AF_UNIX, SOCK_DGRAM);
    }
}