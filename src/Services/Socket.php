<?php

namespace App\Services;

class Socket
{
    const PROTOCOL_UDP = 0;

    /** @var resource */
    private $socket;

    /** @var string */
    private $name;

    /** @var string */
    private $dir;

    /** @var int */
    private $errorCode;

    /** @var string */
    private $errorMsg;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = strtolower($name) . '.sock';
        $this->dir = getenv('SOCKET_DIR') ?: '/var/run/chat';
    }

    public function create(): self
    {
        $socket = socket_create(AF_UNIX, SOCK_DGRAM, self::PROTOCOL_UDP);
        if (!$socket) {
            $this->setLastError();
            throw new \DomainException("Не могу создать AF_UNIX сокет: [$this->errorCode] $this->errorMsg");
        }

        if (!socket_bind($socket, $this->getAddress())) {
            $this->setLastError();
            throw new \DomainException("Не могу привязаться к сокету: [$this->errorCode] $this->errorMsg");
        }

        $this->socket = $socket;

        return $this;
    }

    public function block(): self
    {
        if (!socket_set_block($this->socket)) {
            $this->setLastError();
            throw new \DomainException("Не могу устанавить блокировку сокета: [$this->errorCode] $this->errorMsg");
        }

        return $this;
    }

    public function unblock(): self
    {
        if (!socket_set_nonblock($this->socket)) {
            $this->setLastError();
            throw new \DomainException("Не могу снять блокировку с сокета: [$this->errorCode] $this->errorMsg");
        }

        return $this;
    }

    public function receive(): SocketData
    {
        $data = '';
        $from = '';

        if (socket_recvfrom($this->socket, $data, 65536, 0, $from) === false) {
            throw new \DomainException('Ошибка при получении данных из сокета.');
        }

        return (new SocketData())
            ->setData($data)
            ->setLength(strlen($data))
            ->setFrom($from)
            ->setTo($this->dir . '/' . $this->name);
    }

    public function send(string $data, string $address): void
    {
        $len = strlen($data);
        $bytesSent = socket_sendto($this->socket, $data, $len, 0, $address);
        if ($bytesSent === false) {
            throw new \DomainException('Ошибка при отправке данных в сокет.');
        } else if ($bytesSent != $len) {
            throw new \DomainException($bytesSent . ' байт было отправлено, ожидалось ' . $len . ' байт');
        }
    }

    public function close(): void
    {
        socket_close($this->socket);
        unlink($this->dir . '/' . $this->name);
    }

    private function getAddress(): string
    {
        if (!is_dir($this->dir)) {
            mkdir($this->dir, 0777, true);
        }

        $address = $this->dir . '/' . $this->name;
        if (file_exists($address)) {
            unlink($address);
        }

        return $address;
    }

    private function setLastError(): void
    {
        $this->errorCode = socket_last_error();
        $this->errorMsg = socket_strerror($this->errorCode);
    }
}
