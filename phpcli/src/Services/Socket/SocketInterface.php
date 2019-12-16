<?php

namespace App\Services\Socket;

use App\Services\Socket\Entity\ResultFromSocket;

interface SocketInterface
{
    public function getDirSockets(): string;
    public function createSocket(int $type, string $name);
    public function closeSocket(): bool;
    public function read(): ResultFromSocket;
    public function write(string $message, string $socketName): void;
}