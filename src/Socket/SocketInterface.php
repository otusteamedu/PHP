<?php

namespace HomeWork\Socket;

interface SocketInterface
{
    public function send(string $message, string $address);

    public function bind(string $address);

    public function listen(
        string &$buf,
        string &$name,
        int $port = null,
        int $length = 65536,
        int $flags = 0
    ): int;
}
