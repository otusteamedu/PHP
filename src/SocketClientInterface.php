<?php

namespace crazydope\socket;

interface SocketClientInterface extends SocketInterface
{
    public function connect(string $address);
}