<?php

namespace App\Services;

class Socket
{
    const PROTOCOL_UDP = 0;

    /** @var resource */
    private $socket;

    /** @var string */
    private $address;

    /** @var string */
    private $dir;

    /** @var int */
    private $errorCode;

    /** @var string */
    private $errorMsg;

    /**
     * @param string $address
     */
    public function __construct(string $address)
    {
        if (strlen($address) === 0) {
            throw new \RuntimeException('Неверный адрес сокета.');
        }

        $this->address = $address;
    }

    public function create(): self
    {
        $socket = socket_create(AF_UNIX, SOCK_DGRAM, self::SOCKET_PROTOCOL);
        if (!$socket) {
            $this->setLastError();
            throw new \DomainException("Не могу создать AF_UNIX сокет: [$this->errorCode] $this->errorMsg");
        }

        if (file_exists($this->address)) {
            unlink($this->address);
        }

        if (!is_dir(dirname($this->address))) {
            mkdir(dirname($this->address), 0777, true);
        }

        if (!socket_bind($socket, $this->address)) {
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
            ->setTo($this->address);
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
        unlink($this->address);
    }

    private function setLastError(): void
    {
        $this->errorCode = socket_last_error();
        $this->errorMsg = socket_strerror($this->errorCode);
    }
}
