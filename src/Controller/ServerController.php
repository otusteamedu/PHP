<?php

declare(strict_types=1);

namespace HomeWork\Controller;

use HomeWork\Entity\ConfigInterface;
use HomeWork\Factory\SocketFactoryInterface;
use HomeWork\Socket\SocketInterface;

class ServerController implements ControllerInterface
{
    private ConfigInterface $config;
    private SocketInterface $socket;

    public function __construct(ConfigInterface $config, SocketFactoryInterface $socketFactory)
    {
        $this->config = $config;
        $this->socket = $socketFactory->create($config->getServerSocketAddress());
    }

    public function run(?string $message): void
    {
        $buf = '';
        $name = '';
        while(true) {
            $this->socket->listen($buf, $name);
            printf('New message from client:' . $buf . PHP_EOL);
            $this->socket->send($message, $this->config->getClientSocketAddress());
        }
    }
}
