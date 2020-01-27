<?php

declare(strict_types=1);

namespace Socket\Ruvik\Controller;

use Socket\Ruvik\DTO\InputArgs;
use Socket\Ruvik\DTO\SocketConfig;
use Socket\Ruvik\Factory\SocketFactory;

class ClientController implements ControllerInterface
{
    /**
     * @var SocketFactory
     */
    private $socketFactory;
    /**
     * @var SocketConfig
     */
    private $socketConfig;

    public function __construct(SocketFactory $socketFactory, SocketConfig $socketConfig)
    {
        $this->socketFactory = $socketFactory;
        $this->socketConfig = $socketConfig;
    }

    public function run(InputArgs $inputArgs): void
    {
        $socket = $this->socketFactory->createUnixSocket();
        $socket->connect($this->socketConfig->getClientAddress());

        $socket->sendTo($inputArgs->getMessage(), MSG_EOF, $this->socketConfig->getServerAddress());

        $socket->close();
    }
}
