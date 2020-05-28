<?php

namespace HW4;

/**
 * Class SocketService
 * @package HW4
 */
class SocketService
{
    private $address;
    private $port;
    private $domain;
    private $type;
    private $protocol;
    private $socket;

    CONST READ_MESSAGE_LENGTH = 1024;

    public function __construct($address, $port)
    {
        $this->address = $address;
        $this->port = $port;

        $this->domain = AF_UNIX;
        $this->type = SOCK_STREAM;
        $this->protocol = 0;
    }

    /**
     * Создание сокета
     *
     * @return false|resource
     * @throws \Exception
     */
    public function create()
    {
        $this->socket = socket_create(
            $this->domain,
            $this->type,
            $this->protocol
        );

        $this->isSocketError();

        return $this->socket;
    }

    /**
     * Привязка сокета
     *
     * @throws \Exception
     */
    public function bind(): void
    {
        socket_bind(
            $this->socket,
            $this->address,
            $this->port
        );

        $this->isSocketError();
    }

    /**
     * Прослушка сокета
     *
     * @throws \Exception
     */
    public function listen(): void
    {
        socket_listen($this->socket);

        $this->isSocketError();
    }

    /**
     * Созание соединения с сокетом
     *
     * @throws \Exception
     */
    public function connect(): void
    {
        socket_connect($this->socket, $this->address, $this->port);

        $this->isSocketError();
    }

    /**
     * Закрытие сокета
     *
     * @param null $socket
     */
    public function close($socket = null): void
    {
        $socket = $socket ?? $this->socket;

        socket_close($socket);
    }

    /**
     * Приём соединения на сокете
     *
     * @return resource
     * @throws \Exception
     */
    public function accept()
    {
        $socket = socket_accept($this->socket);

        $this->isSocketError($socket);

        return $socket;
    }

    /**
     * Чтение из сокета
     *
     * @param null $socket
     * @return string
     * @throws \Exception
     */
    public function read($socket = null): string
    {
        $socket = $socket ?? $this->socket;

        $data = socket_read($socket, self::READ_MESSAGE_LENGTH);

        $this->isSocketError($socket);

        return $data;
    }

    /**
     * Запись в сокет
     *
     * @param null $socket
     * @param string $data
     */
    public function write($socket = null, $data = ''): void
    {
        $socket = $socket ?? $this->socket;

        socket_write($socket, $data, self::READ_MESSAGE_LENGTH);
    }

    /**
     * Проверка на ошибки
     *
     * @param null $socket
     * @throws \Exception
     */
    private function isSocketError($socket = null): void
    {
        $socket = $socket ?? $this->socket;
        if (!empty($errorCode = socket_last_error($socket))) {
            $errorMessage = socket_strerror($errorCode);
            throw new \Exception('Socket error code ' . $errorCode . ' with text ' . $errorMessage);
        }
    }
}