<?php

namespace crazydope\socket;

interface SocketFactoryInterface
{
    public function createFromString(string $address);

    public function getType(): int;

    public function setType(int $type): SocketFactoryInterface;
}