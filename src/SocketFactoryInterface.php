<?php

namespace crazydope\socket;

interface SocketFactoryInterface
{
    public function createServer(string $address): SocketServerInterface;

    public function createClient(string $address): SocketClientInterface;
}