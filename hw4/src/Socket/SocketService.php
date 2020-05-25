<?php

namespace HW4\Socket;

class SocketService
{
    const DOMAIN = [
        'inet' => AF_INET,
        'inet6' => AF_INET6,
        'unix' => AF_UNIX,
    ];

    const TYPE = [
        'stream' => SOCK_STREAM,
        'dgram' => SOCK_DGRAM,
        'seqpacket' => SOCK_SEQPACKET,
        'raw' => SOCK_RAW,
        'rdm' => SOCK_RDM,
    ];

    const PROTOCOL = [
        '0' => 0,
        'tcp' => SOL_TCP,
        'udp' => SOL_UDP,
    ];

    /**
     * @param string $domain
     * @param string $type
     * @param string $protocol
     * @param string $address
     * @param string $port
     *
     * @return Socket
     * @throws SocketException
     */
    public function create(
        string $domain,
        string $type,
        string $protocol,
        string $address,
        string $port = '0'
    ): Socket
    {
        self::checkExtension();

        $domain = $this->getDomainCode($domain);
        $type = $this->getTypeCode($type);
        $protocol = $this->getProtocolCode($protocol);
        $port = intval($port);

        $socketResource = socket_create($domain, $type, $protocol);
        if ($socketResource === false) {
            $this->getSocketError();
        }

        return (new Socket($socketResource))
            ->setDomain($domain)
            ->setType($type)
            ->setProtocol($protocol)
            ->setAddress($address)
            ->setPort($port);
    }

    /**
     * @param Socket $socket
     *
     * @throws SocketException
     */
    public function bind(Socket $socket): void
    {
        $socketResource = $socket->getValidSocketResource();

        if ($socket->getDomain() == AF_UNIX) {
            $this->clearUnixSocket($socket->getAddress());
        }

        $result = socket_bind($socketResource, $socket->getAddress(), $socket->getPort());
        if ($result === false) {
            $this->getSocketError();
        }
    }

    /**
     * @param Socket $socket
     * @param int $backlog
     *
     * @throws SocketException
     */
    public function listen(Socket $socket, int $backlog = 0): void
    {
        $socketResource = $socket->getValidSocketResource();

        $result = socket_listen($socketResource, $backlog);
        if ($result === false) {
            $this->getSocketError();
        }
    }

    /**
     * @param Socket $socket
     *
     * @throws SocketException
     */
    public function connect(Socket $socket): void
    {
        $socketResource = $socket->getValidSocketResource();

        $result = socket_connect($socketResource, $socket->getAddress(), $socket->getPort());
        if ($result === false) {
            $this->getSocketError();
        }
    }

    /**
     * @param Socket $socket
     * @param string $buffer
     *
     * @throws SocketException
     */
    public function write(Socket $socket, string $buffer): void
    {
        $socketResource = $socket->getValidSocketResource();

        $length = strlen($buffer);

        while (true) {
            $result = socket_write($socketResource, $buffer, $length);
            if ($result === false) {
                $this->getSocketError();
            }
            if ($result < $length) {
                $buffer = substr($buffer, $result);
                $length -= $result;
            } else {
                break;
            }
        }
    }

    /**
     * @param Socket $socket
     * @param int $length
     * @param int $type
     *
     * @return string
     * @throws SocketException
     */
    public function read(
        Socket $socket,
        int $length,
        int $type = PHP_BINARY_READ
    ): string
    {
        $socketResource = $socket->getValidSocketResource();

        $result = socket_read($socketResource, $length, $type);
        if ($result === false) {
            $this->getSocketError();
        }

        return $result;
    }

    /**
     * @param Socket $socket
     */
    public function close(Socket $socket): void
    {
        if ($socket->isValid()) {
            socket_close($socket->getSocket());
        }
    }

    /**
     * @param Socket $socket
     *
     * @return Socket|bool
     * @throws SocketException
     */
    public function accept(Socket $socket): Socket
    {
        $socketResource = $socket->getValidSocketResource();

        $acceptedSocket = socket_accept($socketResource);
        if (empty($acceptedSocket)) {
            return false;
        }

        return new Socket(
            $acceptedSocket,
            $socket->getDomain(),
            $socket->getType(),
            $socket->getProtocol(),
            $socket->getAddress(),
            $socket->getPort()
        );
    }

    /**
     * @param string $domain
     *
     * @return int
     * @throws SocketException
     */
    public function getDomainCode(string $domain): int
    {
        if (!isset(self::DOMAIN[$domain])) {
            throw new SocketException('Incorrect domain. "' . $domain . '"');
        }

        return self::DOMAIN[$domain];
    }

    /**
     * @param string $type
     *
     * @return int
     * @throws SocketException
     */
    public function getTypeCode(string $type): int
    {
        if (!isset(self::TYPE[$type])) {
            throw new SocketException('Incorrect type. "' . $type . '"');
        }

        return self::TYPE[$type];
    }

    /**
     * @param string $protocol
     *
     * @return int
     * @throws SocketException
     */
    public function getProtocolCode(string $protocol): int
    {
        if (!isset(self::PROTOCOL[$protocol])) {
            throw new SocketException('Incorrect protocol. "' . $protocol . '"');
        }

        return self::PROTOCOL[$protocol];
    }

    /**
     * @param Socket|null $socket
     *
     * @throws SocketException
     */
    private function getSocketError(?Socket $socket = null): void
    {
        $socketResource = null;
        if (!empty($socket)) {
            $socketResource = $socket->getValidSocketResource();
        }

        $errorCode = socket_last_error($socketResource);
        $errorMsg = socket_strerror($errorCode);

        socket_clear_error($socketResource);

        if (!empty($errorCode)) {
            throw new SocketException('[' . $errorCode . ']' . $errorMsg);
        }
    }

    /**
     * @param string $address
     */
    private function clearUnixSocket(string $address)
    {
        if (file_exists($address)) {
            unlink($address);
        }
    }

    /**
     * @throws SocketException
     */
    private static function checkExtension(): void
    {
        if (!extension_loaded('sockets')) {
            throw new SocketException('The sockets extension is not loaded.');
        }
    }
}