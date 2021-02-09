<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Sockets;

interface ISocketClient extends ISocket, ISocketCanRead, ISocketCanWrite
{
    public function connect(string $address, int $port = 0): bool;
}
