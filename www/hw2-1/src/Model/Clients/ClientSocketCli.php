<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Clients;

class ClientSocketCli implements IClient
{
    private $instance = null;
    private $is_connected = true;

    public function __construct($instance)
    {
        $this->instance = $instance;
    }

    public function getInstance()
    {
        return $this->instance;
    }

    public function isConnected(): bool
    {
        return $this->is_connected;
    }

    public function connect()
    {
        $this->is_connected = true;
    }

    public function disconnect()
    {
        $this->is_connected = false;
    }
}
