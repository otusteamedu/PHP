<?php

namespace Src\Database\Connectors;

abstract class Connector
{
    protected ?string $host;
    protected ?int $port;
    protected array $config;

    public function __construct()
    {
        $this->host     = $this->config['host'] ?? null;
        $this->port     = $this->config['port'] ?? null;
    }
}