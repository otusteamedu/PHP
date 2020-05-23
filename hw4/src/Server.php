<?php

namespace HW4;

use HW4\Config\Config;
use HW4\Config\ConfigException;
use HW4\Socket\SocketService;
use HW4\Socket\SocketException;
use HW4\Socket\Socket;

class Server
{
    private Socket $socket;

    private Config $config;
    private SocketService $socketService;

    public function __construct(Config $config, SocketService $socketService)
    {
        $this->config = $config;
        $this->socketService = $socketService;
    }

    /**
     * @throws SocketException
     * @throws ConfigException
     */
    public function init(): void
    {
        $this->socket = $this->socketService->create(
            $this->config->get('socket_domain'),
            $this->config->get('socket_type'),
            $this->config->get('server_protocol'),
            $this->config->get('server_address'),
            $this->config->get('server_port')
        );
        $this->socketService->bind($this->socket);
        $this->socketService->listen($this->socket);
    }

    /**
     * @param string $message
     *
     * @throws SocketException
     */
    public function response(string $message): void
    {
        while (true) {
            $acceptedSocketResource = $this->socketService->accept($this->socket);
            $this->socketService->write($acceptedSocketResource, $message . ' ; ' . date('Y-m-d H:i:s'));
            $this->socketService->close($acceptedSocketResource);
        }
    }
}