<?php

declare(strict_types=1);

namespace Socket\Ruvik\DTO;

class SocketConfig
{
    private string $serverAddress;
    private string $clientAddress;

    public function __construct(string $serverAddress, string $clientAddress)
    {
        $this->serverAddress = $serverAddress;
        $this->clientAddress = $clientAddress;
    }

    public function getServerAddress(): string
    {
        return $this->serverAddress;
    }

    public function getClientAddress(): string
    {
        return $this->clientAddress;
    }
}
