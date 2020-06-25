<?php

namespace HomeWork\Entity;

class DefaultConfig implements ConfigInterface
{
    private string $clientSocketAddress;
    private string $serverSocketAddress;

    public function __construct(string $clientSocketAddress, string $serverSocketAddress)
    {
        $this->clientSocketAddress = $clientSocketAddress;
        $this->serverSocketAddress = $serverSocketAddress;
    }

    public function getClientSocketAddress(): string
    {
        return $this->clientSocketAddress;
    }

    public function getServerSocketAddress(): string
    {
        return $this->serverSocketAddress;
    }
}
