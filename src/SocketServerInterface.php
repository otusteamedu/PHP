<?php

namespace crazydope\socket;

interface SocketServerInterface extends SocketInterface
{
    public function accept(): SocketInterface;

    public function bind(string $address): SocketServerInterface;

    public function listen(int $backlog = 0): SocketServerInterface;
}