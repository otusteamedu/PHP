<?php

namespace crazydope\socket;

interface SocketInterface
{
    public function write(string $buffer): int;

    public function read(int $length, int $type = PHP_BINARY_READ): string;

    public function getOption(int $level, int $name);

    public function setOption(int $level, int $name, $optVal): bool;

    public function getResource();

    public function close();
}