<?php

namespace HomeWork\Entity;

interface ConfigInterface
{
    public function getClientSocketAddress(): string;

    public function getServerSocketAddress(): string;
}
