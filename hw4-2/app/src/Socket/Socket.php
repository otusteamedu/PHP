<?php

declare(strict_types=1);

namespace App\Socket;

use App\Socket\Exceptions\SocketConnectionException;
use App\Socket\Exceptions\SocketCreateException;
use App\Socket\Exceptions\SocketReadException;
use App\Socket\Exceptions\SocketWriteException;
use InvalidArgumentException;

class Socket
{

    private const MAX_NUMBER_OF_BYTES_TO_READ = 1024;
    protected string $address;
    protected int    $port;

    /**
     * @var resource|false
     */
    protected $socket;

    protected final function __construct()
    {

    }

    /**
     * @param string $address
     * @param int    $port
     *
     * @return self
     * @throws SocketCreateException
     */
    public static function createFromAddress(string $address, int $port): self
    {
        self::assertAddressIsSpecified($address);
        self::assertPortIsSpecified($port);

        $newSocket = new self();

        $newSocket->address = $address;
        $newSocket->port = $port;

        $newSocket->createSocket();

        return $newSocket;

    }

    public static function createFromSocketResource($socketResource): self
    {
        $newSocket = new self();

        $newSocket->socket = $socketResource;

        return $newSocket;
    }

    protected static function assertAddressIsSpecified(string $address)
    {
        if (empty($address)) {
            throw new InvalidArgumentException('Не указан адрес');
        }
    }

    protected static function assertPortIsSpecified(int $port)
    {
        if ($port <= 0) {
            throw new InvalidArgumentException('Не указан порт');
        }
    }

    /**
     * @throws SocketCreateException
     */
    protected function createSocket(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if ($this->socket === false) {
            throw new SocketCreateException('Ошибка создания сокета: ' . $this->getLastError());
        }
    }

    /**
     * @throws SocketConnectionException
     */
    public function connection(): void
    {
        if (!socket_connect($this->socket, $this->address, $this->port)) {
            throw new SocketConnectionException('Не удалось подключиться к сокету: ' . $this->getLastError());
        }
    }

    /**
     * @return string
     * @throws SocketReadException
     */
    public function read(): string
    {
        $data = socket_read($this->socket, self::MAX_NUMBER_OF_BYTES_TO_READ);

        if ($data === false) {
            throw new SocketReadException('Не удалось получить данные: ' . $this->getLastError());
        }

        return rtrim($data);
    }

    /**
     * @param string $data
     *
     * @throws SocketWriteException
     */
    public function write(string $data): void
    {
        if (socket_write($this->socket, $data, strlen($data)) === false) {
            throw new SocketWriteException('Не удалось записать данные: ' . $this->getLastError());
        }
    }

    public function close(): void
    {
        if (!$this->isSocketCreated()) {
            return;
        }

        $this->shutdownSocket($this->socket);
        $this->closeSocket($this->socket);
    }

    public function isSocketCreated(): bool
    {
        return !empty($this->socket);
    }

    private function shutdownSocket($socket): void
    {
        socket_shutdown($socket);
    }

    private function closeSocket($socket): void
    {
        socket_close($socket);
    }

    protected function getLastError(): string
    {
        $errorCode = $this->getLastErrorCode();
        $errorMessage = $this->getLastErrorMessage($errorCode);

        return "{[$errorCode] {$errorMessage}}";

    }

    private function getLastErrorCode(): int
    {
        return socket_last_error($this->socket);
    }

    private function getLastErrorMessage(int $errorCode): string
    {
        return socket_strerror($errorCode);
    }

}