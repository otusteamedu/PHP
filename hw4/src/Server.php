<?php

namespace HW4;

use HW4\Config\Config;
use HW4\Config\ConfigException;
use HW4\Socket\SocketService;
use HW4\Socket\SocketException;
use HW4\Socket\Socket;

class Server
{
    const LENGTH = 1024;

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
     * @throws SocketException
     */
    public function response(): void
    {
        while (true) {
            $acceptedSocket = $this->socketService->accept($this->socket);

            $message = $this->socketService->read($acceptedSocket, self::LENGTH);
            $this->socketService->write($acceptedSocket, $this->answer($message));

            $this->socketService->close($acceptedSocket);
        }
    }

    /**
     * @param string $message
     *
     * @return string
     */
    private function answer(string $message)
    {
        switch($message) {
            case 'PING':
                return 'PONG';
                break;

            default:
                return 'You wrote: ' . $message;
                break;
        }
    }
}