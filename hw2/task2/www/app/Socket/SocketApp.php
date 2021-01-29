<?php

namespace App2\Socket;

use App2\Exception\ExceptionSocket;

set_time_limit(0);
ob_implicit_flush();

/**
 * Class SocketApp
 * @package App2\Socket
 */
class SocketApp
{
    private string $serverSideSockPath = '/tmp/server.sock';
    private string $clientSideSockPath = '/tmp/client.sock';
    private $socket = false;
    private int $port = 65536;

    /**
     * SocketApp constructor.
     * @throws ExceptionSocket
     */
    public function __construct()
    {
        if (!extension_loaded('sockets')) {
            throw new ExceptionSocket('Расширение сокетов не загружено.');
        }

        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if (!$this->socket) {
            throw new ExceptionSocket('Невозможно создать сокет AF_UNIX.');
        }
    }

    /**
     * @throws ExceptionSocket
     */
    public function server()
    {
        if (!socket_bind($this->socket, $this->serverSideSockPath)) {
            throw new ExceptionSocket('Невозможно привязать к ' . $this->serverSideSockPath);
        }

        while (true) {
            echo "Жду сообщений...\n";
            $dataSocket = $this->getDataSocket();
            echo "от Клиента: " . $dataSocket['message'] . "\n\n";

            $this->sendMessage("Доставлено", $dataSocket['from']);
            echo "Запрос обработан\n\n";
        }
    }

    /**
     * @throws ExceptionSocket
     */
    public function client()
    {
        if (!socket_bind($this->socket, $this->clientSideSockPath)) {
            throw new ExceptionSocket('Невозможно привязать к ' . $this->clientSideSockPath);
        }

        do {
            echo "Введите сообщение:\n";
            $message = trim(fread(STDIN, 80));
            $this->sendMessage($message, $this->serverSideSockPath);
            $dataSocket = $this->getDataSocket();
            echo "от Сервера: " . $dataSocket['message'] . "\n\n";
        } while ($message != 'close');

        socket_close($this->socket);
        unlink($this->clientSideSockPath);
        echo "Клиент вышел\n";
    }

    /**
     * @param $message
     * @param $from
     * @throws ExceptionSocket
     */
    private function sendMessage($message, $from)
    {
        if (!socket_set_nonblock($this->socket)) {
            throw new ExceptionSocket('Невозможно установить неблокирующий режим для сокета');
        }

        $lengthMessage = strlen($message);
        $bytesSent = socket_sendto($this->socket, $message, $lengthMessage, 0, $from);
        if ($bytesSent == -1) {
            throw new ExceptionSocket('Произошла ошибка при отправке в сокет');
        } elseif ($bytesSent != $lengthMessage) {
            throw new ExceptionSocket($bytesSent . ' байтов были отправлены вместо ' . $lengthMessage . ' ожидаймых байтов');
        }
    }

    /**
     * @return array
     * @throws ExceptionSocket
     */
    private function getDataSocket(): array
    {
        $dataSocket = [];
        if (!socket_set_block($this->socket)) {
            throw new ExceptionSocket('Невозможно установить режим блокировки для сокета');
        }

        $bytesReceived = socket_recvfrom($this->socket, $dataSocket['message'], $this->port, 0, $dataSocket['from']);
        if ($bytesReceived == -1) {
            throw new ExceptionSocket('Произошла ошибка при получении из сокета');
        }

        return $dataSocket;
    }

    public function __destruct()
    {
        if ($this->socket) {
            socket_close($this->socket);
        }

        unlink($this->clientSideSockPath);
        unlink($this->serverSideSockPath);
    }
}