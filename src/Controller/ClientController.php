<?php

declare(strict_types=1);

namespace Controller;

use Service\ConfigProvider;
use Service\SocketProvider;
use Socket\Exception\BindSocketException;
use Socket\Exception\ChangeSocketModeException;
use Socket\Exception\ListenSocketException;
use Socket\Exception\SendSocketException;
use Socket\Socket;

class ClientController implements ControllerInterface
{
    private Socket $socket;

    private string $serverSocketAddress;

    private string $clientSocketAddress;

    public function __construct(SocketProvider $socketProvider, ConfigProvider $configProvider)
    {
        $this->socket = $socketProvider->createSocket();

        $this->clientSocketAddress = $configProvider->getClientSocketAddress();
        $this->serverSocketAddress = $configProvider->getServerSocketAddress();
    }

    /**
     * @param string|null $message
     * @throws BindSocketException
     * @throws ChangeSocketModeException
     * @throws ListenSocketException
     * @throws SendSocketException
     */
    public function run(?string $message): void
    {
        $this->socket->bind($this->clientSocketAddress);

        $message ??= 'Message';
        $len = strlen($message);
        $bytesSent = $this->socket->send($message, $len, $this->serverSocketAddress);
        echo "Sent \"$message\" to {$this->serverSocketAddress} ($bytesSent bytes)\n";

        $buf = '';
        $from = '';
        $bytesReceived = $this->socket->listen($buf, $from);
        echo "Received \"$buf\" from $from ($bytesReceived bytes)\n";

        $this->socket->close();
        echo "Client exits\n\n";
    }
}