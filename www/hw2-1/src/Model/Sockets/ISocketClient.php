<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Sockets;

interface ISocketClient extends ISocket
{
    public function connect(string $address, int $port = 0): bool;
    public function isConnected(): bool;
    public function sendMsg(string $msg);
    public function readMsg(): ?string;
}
