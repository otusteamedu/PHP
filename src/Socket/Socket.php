<?php

declare(strict_types=1);

namespace Socket;

use Socket\Exception\BindSocketException;
use Socket\Exception\ChangeSocketModeException;
use Socket\Exception\CreateSocketException;
use Socket\Exception\ListenSocketException;
use Socket\Exception\SendSocketException;

class Socket
{
    /**
     * @var resource
     */
    private $socket;

    /**
     * @var int
     */
    private int $domain;

    /**
     * @var int
     */
    private int $type;

    /**
     * @var string
     */
    private string $address;

    /**
     * @var int|null
     */
    private ?int $port;

    /**
     * Socket constructor.
     * @param int $domain
     * @param int $type
     * @param int $protocol
     * @throws CreateSocketException
     */
    public function __construct(int $domain, int $type, int $protocol = 0)
    {
        if (!extension_loaded('sockets')) {
            throw new CreateSocketException('The sockets extension is not loaded.');
        }

        $socket = socket_create($domain, $type, $protocol);
        if ($socket === false) {
            throw new CreateSocketException("Unable to create $domain socket of type $type and protocol $protocol");
        }
        $this->socket = $socket;
        $this->domain = $domain;
        $this->type = $type;
    }

    /**
     * @param string $address
     * @param int $port
     * @throws BindSocketException
     */
    public function bind(string $address, int $port = 0): void
    {
        if (file_exists($address)) {
            unlink($address);
        }

        if (!socket_bind($this->socket, $address, $port)) {
            throw new BindSocketException("Unable to bind to address $address and port $port");
        }
        $this->address = $address;
        $this->port = $port;
    }

    /**
     * @param string $buf
     * @param string $name
     * @param int|null $port
     * @param int $length
     * @param int $flags
     * @return int
     * @throws ChangeSocketModeException
     * @throws ListenSocketException
     */
    public function listen(
        string &$buf,
        string &$name,
        int $port = null,
        int $length = 65536,
        int $flags = 0
    ): int {
        if (!socket_set_block($this->socket)) {
            throw new ChangeSocketModeException("Unable to set blocking mode for socket {$this->getName()}");
        }

        $bytesReceived = socket_recvfrom($this->socket, $buf, $length, $flags, $name, $port);

        if ($bytesReceived === false || $bytesReceived === -1) {
            throw new ListenSocketException("An error occurred while receiving from the socket {$this->getName()}");
        }

        if (!socket_set_nonblock($this->socket)) {
            throw new ChangeSocketModeException("Unable to set non-blocking mode for socket {$this->getName()}");
        }

        return $bytesReceived;
    }

    /**
     * @param string $buf
     * @param int $length
     * @param string $address
     * @param int $port
     * @param int $flags
     * @return int
     * @throws SendSocketException
     */
    public function send(
        string $buf,
        int $length,
        string $address,
        int $port = null,
        int $flags = 0
    ): int {
        $bytesSent = socket_sendto($this->socket, $buf, $length, $flags, $address, $port ?? 0);

        if ($bytesSent === false || $bytesSent === -1) {
            throw new SendSocketException("An error occurred while sending to the socket {$this->getName()}");
        } elseif ($bytesSent !== $length) {
            throw new SendSocketException("$bytesSent bytes have been sent instead of the $length bytes expected");
        }

        return $bytesSent;
    }

    public function close(): void
    {
        socket_close($this->socket);
        if (file_exists($this->address)) {
            unlink($this->address);
        }
    }

    private function getName(): string
    {
        return $this->address . ($this->port === null ? '' : $this->port . ':');
    }
}
