<?php

declare(strict_types=1);

namespace App\Socket;

use App\Socket\Exceptions\SocketAcceptException;
use App\Socket\Exceptions\SocketBindException;
use App\Socket\Exceptions\SocketCreateException;
use App\Socket\Exceptions\SocketListenException;
use InvalidArgumentException;

class ServerSocket extends Socket
{

    private int $maxConnection;

    /**
     * @param string $address
     * @param int    $port
     * @param int    $maxConnection
     *
     * @return self
     * @throws SocketCreateException
     */
    public static function create(string $address, int $port, int $maxConnection): self
    {
        self::assertAddressIsSpecified($address);
        self::assertPortIsSpecified($port);
        self::assertMaxConnectionIsSpecified($maxConnection);

        $newSocket = new self();

        $newSocket->address = $address;
        $newSocket->port = $port;
        $newSocket->maxConnection = $maxConnection;

        $newSocket->deleteOldSocketFile();
        $newSocket->createSocket();

        return $newSocket;

    }

    private static function assertMaxConnectionIsSpecified(int $maxConnection)
    {
        if ($maxConnection <= 0) {
            throw new InvalidArgumentException('Не указано максимальное количество соединений');
        }
    }

    /**
     * @throws SocketBindException
     */
    public function bind(): void
    {
        if (!socket_bind($this->socket, $this->address, $this->port)) {
            throw new SocketBindException('Не удалось связать сокет с адресом: ' . $this->getLastError());
        }
    }

    /**
     * @throws SocketListenException
     */
    public function startListen(): void
    {
        if (!socket_listen($this->socket, $this->maxConnection)) {
            throw new SocketListenException('Не удалось запустить прослушивание сокета: ' . $this->getLastError());
        }
    }

    /**
     * @return Socket
     * @throws SocketAcceptException
     */
    public function startAccept(): Socket
    {
        $acceptedSocket = socket_accept($this->socket);

        if ($acceptedSocket === false) {
            throw new SocketAcceptException('Не удалось принять входящее соединения: ' . $this->getLastError());
        }

        return self::createFromSocketResource($acceptedSocket);
    }

    public function close(): void
    {
        parent::close();

        $this->deleteOldSocketFile();
    }

    private function deleteOldSocketFile(): void
    {
        if (file_exists($this->address)) {
            unlink($this->address);
        }
    }

}