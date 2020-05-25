<?php

namespace HW4;

use HW4\Config\Config;
use HW4\Config\ConfigException;
use HW4\Socket\SocketService;
use HW4\Socket\SocketException;

class Client
{
    const LENGTH = 1024;

    private Config $config;
    private SocketService $socketService;

    public function __construct(Config $config, SocketService $socketService)
    {
        $this->config = $config;
        $this->socketService = $socketService;
    }

    /**
     * @param string $message
     *
     * @return string
     * @throws ConfigException
     * @throws SocketException
     */
    public function request(string $message): string
    {
        $socket = $this->socketService->create(
            $this->config->get('socket_domain'),
            $this->config->get('socket_type'),
            $this->config->get('server_protocol'),
            $this->config->get('server_address'),
            $this->config->get('server_port')
        );

        $this->socketService->connect($socket);

        $this->socketService->write($socket, $message);
        $result = $this->socketService->read($socket, self::LENGTH);

        $this->socketService->close($socket);

        return $result;
    }
}