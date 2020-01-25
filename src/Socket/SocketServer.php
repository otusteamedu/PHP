<?php

namespace App\Socket;

use App\Socket\Exceptions\SocketException;
use const PHP_EOL;

/**
 * Class SocketServer
 *
 * @package app\Socket
 */
class SocketServer extends BaseSocket
{
    /**
     *
     */
    public function serve(): void
    {
        echo 'Сервер запущен и готов принимать соединения...' . PHP_EOL;

        while (true) {
            if ($clientSocket = $this->accept()) {
                $message = $this->read($clientSocket);
                echo 'Получено сообщение: ' . $message . PHP_EOL;
            }
        }
    }

    /**
     * @throws SocketException
     */
    protected function init(): void
    {
        $this->create();
        $this->removeSocketFileIfExists();
        $this->bind();
        $this->listen();
    }
}