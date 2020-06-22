<?php

namespace HomeWork\Socket;

use HomeWork\Socket\Exception\SocketBindException;
use HomeWork\Socket\Exception\SocketCreateException;
use HomeWork\Socket\Exception\SocketSendException;
use HomeWork\Socket\Helper\ErrorMessageHelper;
//use Socket\Exception\ListenSocketException;

class UdpSocket implements SocketInterface
{
    /** @var resource */
    private $socket;
    private string $address;
    private int $port;
    private int $flags;

    public function __construct(string $address, $port = 0, $flags = 0)
    {
        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if ($this->socket === false) {
            throw new SocketCreateException(ErrorMessageHelper::getCreateErrorMessage(socket_last_error()));
        }
        $this->address = $address;
        $this->port = $port;
        $this->flags = $flags;

        $this->bind($this->address);
    }

    public function __destruct()
    {
        if ($this->socket !== null && $this->socket !== false) {
            socket_close($this->socket);
        }
    }

    public function send(string $message, string $address)
    {
        $len = strlen($message);
        $sendResult = socket_sendto($this->socket, $message, $len, $this->flags, $address, $this->port);

        if ($sendResult === false) {
            throw new SocketSendException(ErrorMessageHelper::getSendErrorMessage(socket_last_error()));
        }

        return $sendResult;
    }

    /**
     * @param string $address
     * @return bool
     * @throws SocketBindException
     */
    public function bind(string $address): bool
    {
        if (file_exists($address)) {
            unlink($address);
        }

        $socketBindResult = socket_bind($this->socket, $address);

        if ($socketBindResult === false) {
            throw new SocketBindException(ErrorMessageHelper::getBindErrorMessage(socket_last_error()));
        }

        return $socketBindResult;
    }

    public function listen(
        string &$buf,
        string &$name,
        int $port = null,
        int $length = 65536,
        int $flags = 0
    ): int
    {
        $bytesReceived = socket_recvfrom($this->socket, $buf, $length, $flags, $name, $port);
        if ($bytesReceived === false || $bytesReceived === -1) {
            throw new \Exception("An error occurred while receiving from the socket.");
        }

        return $bytesReceived;
    }

    public function getMessage()
    {
        socket_recvfrom($this->socket, $buf, 65000, 0, $from, $port);

        echo "Получено $buf с удалённого адреса $from и удалённого порта $port" . PHP_EOL;
    }
}