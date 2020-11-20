<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Sockets;

interface ISocketServer extends ISocket
{
    public function bind(string $address, int $port = 0): bool;
    public function listen(int $socket_listen_backlog): bool;
    public function set_nonblock(): bool;
    public function acceptConnection();
    public function writeMsg($client, string $msg): int;
    public function readMsg($client): ?string;
    public function shutdownClient($client): bool;
    public function getMaxClientsCount(): int;
    public function setMaxClientsCount(int $max_clients);
    public function getCheckTimeout(): int;
    public function setCheckTimeout(int $check_timeout);
    public function getChangesCount(array &$read, ?array &$write, ?array &$except): int;
}
