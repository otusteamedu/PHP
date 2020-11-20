<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Sockets;

interface ISocket
{
    const SOCKET_EXT_NAME = 'sockets';
    public function getInstance();
    public function isExtLoaded(): bool;
    public function isCreated(): bool;
    public function setSendFlags(int $send_flags);
    public function setReadBuf(int $read_buf);
    public function setReadType(int $read_type);
    public function close();
}
