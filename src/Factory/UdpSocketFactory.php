<?php

namespace HomeWork\Factory;

use HomeWork\Socket\SocketInterface;
use HomeWork\Socket\UnixSocket;

class UdpSocketFactory implements SocketFactoryInterface
{
    public function create(string $address): SocketInterface
    {
        return new UnixSocket($address);
    }
}