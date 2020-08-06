<?php


namespace RedisApp;


trait ConfigRedisBD
{
    private string $connectHost = 'localhost';
    private int $connectPort = 6379;

    public function getConnectHost(): string
    {
        return $this->connectHost;
    }

    public function setConnectHost(string $connectHost): void
    {
        $this->connectHost = $connectHost;
    }

    public function getConnectPort(): int
    {
        return $this->connectPort;
    }

    public function setConnectPort(int $connectPort): void
    {
        $this->connectPort = $connectPort;
    }

    public function readFromFile(): bool
    {
        return true;
    }

    public function writeToFile(): bool
    {
        return true;
    }
}