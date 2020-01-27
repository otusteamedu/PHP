<?php

declare(strict_types=1);

namespace Socket\Ruvik\Factory;

use Socket\Ruvik\Exception\ExceptionInterface;
use Socket\Ruvik\Exception\RuntimeException;
use Socket\Ruvik\Socket\Socket;

class SocketFactory
{
    public function create(int $domain, int $type, int $protocol): Socket
    {
        $sock = @socket_create($domain, $type, $protocol);
        if ($sock === false) {
            throw new RuntimeException('Can not create socket');
        }
        return new Socket($sock);
    }

    public function createTcp4(): Socket
    {
        return $this->create(AF_INET, SOCK_STREAM, SOL_TCP);
    }

    public function createUnixSocket(): Socket
    {
        return $this->create(AF_INET, SOCK_DGRAM, 0);
    }

    /**
     * @param string $ip
     * @param int $port
     * @return Socket
     * @throws ExceptionInterface
     */
    public function createClient(string $ip, int $port = 0): Socket
    {
        $socket = $this->createTcp4();

        try {
            $socket->connect($ip, $port);
        } catch (ExceptionInterface $exception) {
            $socket->close();
            throw $exception;
        }

        return $socket;
    }

    /**
     * @param string $ip
     * @param int $port
     * @return Socket
     * @throws ExceptionInterface
     */
    public function createServer(string $ip, int $port = 0): Socket
    {
        $socket = $this->createTcp4();

        try {
            $socket->bind($ip, $port);
            $socket->listen();
        } catch (ExceptionInterface $exception) {
            $socket->close();
            throw $exception;
        }

        return $socket;
    }
}
