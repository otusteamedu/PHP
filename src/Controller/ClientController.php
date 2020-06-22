<?php

declare(strict_types=1);

namespace HomeWork\Controller;

use HomeWork\Entity\ConfigInterface;
use HomeWork\Factory\SocketFactoryInterface;
use HomeWork\Socket\SocketInterface;

class ClientController implements ControllerInterface
{
    private ConfigInterface $config;
    private SocketInterface $socket;

    public function __construct(ConfigInterface $config, SocketFactoryInterface $socketFactory)
    {
        $this->config = $config;
        $this->socket = $socketFactory->create($config->getClientSocketAddress());
    }

    public function run(?string $message): void
    {
        $this->socket->send($message, $this->config->getServerSocketAddress());
        $buf = '';
        $name = '';

        $this->socket->listen($buf, $name);
        printf('New message:' . $buf . PHP_EOL);
    }
}
