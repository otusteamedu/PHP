<?php

namespace HomeWork\Factory;

use HomeWork\Socket\SocketInterface;
use HomeWork\Socket\UdpSocket;

class UdpSocketFactory implements SocketFactoryInterface
{
    public function create(string $address): SocketInterface
    {
        return new UdpSocket($address);
    }
}