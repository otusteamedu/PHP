<?php

namespace App\Socket;

use App\Socket\Exceptions\SocketException;

use function file_exists;
use function socket_accept;
use function socket_bind;
use function socket_connect;
use function socket_create;
use function socket_last_error;
use function socket_listen;
use function socket_read;
use function socket_strerror;
use function socket_write;
use function strlen;
use function unlink;
use const AF_UNIX;
use const SOCK_STREAM;

/**
 * Class BaseSocket
 *
 * @package app\Socket
 */
abstract class BaseSocket
{
    protected string $address;

    protected int $maxMessageLength = 1000;

    /** @var resource */
    protected $socket;

    /**
     * BaseSocket constructor.
     *
     * @param  array  $config
     */
    public function __construct(array $config = [])
    {
        $this->address = $config['address'] ?? '';
        if (!$this->address) {
            throw new SocketException('Необходимо указать адрес сокета "address"');
        }
        $this->maxMessageLength = $config['maxMessageLength'] ?: $this->maxMessageLength;

        $this->init();
    }

    /**
     * @throws SocketException
     */
    protected function create(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if ($this->socket === false) {
            throw new SocketException($this->getSocketErrorMessage('Ошибка при создании сокета'));
        }
    }

    /**
     * @throws SocketException
     */
    protected function removeSocketFileIfExists(): void
    {
        if (file_exists($this->address)) {
            $isRemoved = unlink($this->address);
            if (!$isRemoved) {
                throw new SocketException('Не удалось удалить файл сокета');
            }
        }
    }

    /**
     * @throws SocketException
     */
    protected function bind(): void
    {
        $isBound = socket_bind($this->socket, $this->address);

        if ($isBound === false) {
            throw new SocketException($this->getSocketErrorMessage('Ошибка при привязке имени к сокету'));
        }
    }

    /**
     * @throws SocketException
     */
    protected function listen(): void
    {
        $isListening = socket_listen($this->socket);

        if ($isListening === false) {
            throw new SocketException($this->getSocketErrorMessage('Ошибка прослушивания входящих соединений на сокете'));
        }
    }

    /**
     * @throws SocketException
     */
    protected function connect(): void
    {
        $isConnected = socket_connect($this->socket, $this->address);

        if ($isConnected === false) {
            throw new SocketException($this->getSocketErrorMessage('Не удалось установить соединение с сокетом'));
        }
    }

    /**
     * @param  string  $buffer
     *
     * @throws SocketException
     */
    protected function write(string $buffer): void
    {
        $sentBytes = socket_write($this->socket, $buffer);

        if ($sentBytes === false) {
            throw new SocketException($this->getSocketErrorMessage('Не удалось записать сообщение в сокет'));
        }

        if ($sentBytes !== strlen($buffer)) {
            throw new SocketException('Сообщение передано не полностью');
        }
    }

    /**
     * @param  resource  $socket
     *
     * @return string
     */
    protected function read($socket): string
    {
        $message = socket_read($socket, $this->maxMessageLength);

        if ($message === false) {
            throw new SocketException($this->getSocketErrorMessage('Не удалось прочитать сообщение из сокета'));
        }

        return $message;
    }

    /**
     * @return false|resource
     */
    protected function accept()
    {
        return socket_accept($this->socket);
    }

    /**
     * @param  string  $message
     *
     * @return string
     */
    private function getSocketErrorMessage(string $message): string
    {
        return $message . ': ' . socket_strerror(socket_last_error());
    }

    /**
     * @throws SocketException
     */
    abstract protected function init(): void;
}