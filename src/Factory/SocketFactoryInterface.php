<?php

namespace HomeWork\Factory;

use HomeWork\Socket\SocketInterface;

interface SocketFactoryInterface
{
    public function create(string $address): SocketInterface;
}
