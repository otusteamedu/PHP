<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Sockets;

interface ISocketServer extends ISocket, ISocketCanRead, ISocketCanWrite
{
    public function bind(string $address, int $port = 0): bool;
    public function listen(int $socket_listen_backlog): bool;
    public function setNonBlock(): bool;
    public function accept();
    public function shutdownClient($client): bool;
    public function getChangesCount(): int;
    public function getCheckTimeout(): int;
    public function setCheckTimeout(int $check_timeout);
    public function getReadSockets(): array;
    public function addSocketToRead($socket);
}
