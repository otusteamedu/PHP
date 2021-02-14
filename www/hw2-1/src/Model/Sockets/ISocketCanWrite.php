<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Sockets;

interface ISocketCanWrite
{
    public function write($socket, string $buffer, int $write_length = 0): int;
}
