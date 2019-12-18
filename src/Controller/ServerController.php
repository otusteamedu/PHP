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

class ServerController implements ControllerInterface
{
    private Socket $socket;

    private string $serverSocketAddress;

    public function __construct(SocketProvider $socketProvider, ConfigProvider $configProvider)
    {
        $this->socket = $socketProvider->createSocket();
        $this->serverSocketAddress = $configProvider->getServerSocketAddress();
    }

    /**
     * @param string|null $response
     * @throws BindSocketException
     * @throws ChangeSocketModeException
     * @throws ListenSocketException
     * @throws SendSocketException
     */
    public function run(?string $response): void
    {
        $this->socket->bind($this->serverSocketAddress);
        $response ??= 'Response';
        while (true) {
            $buf = '';
            $from = '';
            echo "Ready to receive...\n";
            $bytesReceived = $this->socket->listen($buf, $from);
            echo "Received \"$buf\" from $from ($bytesReceived bytes)\n";

            $buf .= ' -> ' . $response;
            $len = strlen($buf);
            $bytesSent = $this->socket->send($buf, $len, $from);
            echo "Sent \"$buf\" to $from ($bytesSent bytes)\n";

            echo "Request processed\n";
        }
    }
}