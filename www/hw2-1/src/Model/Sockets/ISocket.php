<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Sockets;

interface ISocket
{
    public const SOCKET_EXT_NAME = 'sockets';
    public function getSocketType(): int;
    public function getInstance();
    public function isExtLoaded(): bool;
    public function isCreated(): bool;
    public function close();
}
