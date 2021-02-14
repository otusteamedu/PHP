<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Sockets;

interface ISocketCanRead
{
    public function read($socket, int $length = 2048, int $type = PHP_BINARY_READ): ?string;
}
