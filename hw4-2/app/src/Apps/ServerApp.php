<?php

declare(strict_types=1);

namespace App\Apps;

use App\Console\Console;
use App\Socket\Exceptions\SocketAcceptException;
use App\Socket\Exceptions\SocketReadException;
use App\Socket\Exceptions\SocketWriteException;
use App\Socket\ServerSocket;
use Exception;

class ServerApp
{

    private const COMMAND__STOP = 'stop';
    private ServerSocket $socket;

    public function __construct(ServerSocket $socket)
    {
        $this->socket = $socket;
    }

    public function start(): void
    {
        try {
            $this->socket->bind();
            $this->socket->startListen();
            Console::success('Сервер запущен');

            $this->startAcceptOnSocket();
        } catch (Exception $e) {
            Console::lineBreak();
            Console::error($e->getMessage());
        } finally {
            $this->stop();
        }
    }

    /**
     * @throws SocketAcceptException
     * @throws SocketReadException
     * @throws SocketWriteException
     */
    private function startAcceptOnSocket(): void
    {
        while (true) {
            Console::info('Ожидание новых соединений...');

            $acceptedSocket = $this->socket->startAccept();

            if (!$data = $acceptedSocket->read()) {
                $acceptedSocket->close();
                continue;
            }

            if ($this->isItStopCommand($data)) {
                break;
            }

            Console::info('Получено новое сообщение: ' . $data);
            $response = Console::waitingForUserInput('Введите текст ответа: ');

            $acceptedSocket->write($response);
            $acceptedSocket->close();
        }
    }

    private function isItStopCommand(string $command): bool
    {
        return ($command === self::COMMAND__STOP);
    }

    public function stop(): void
    {
        $this->socket->close();

        Console::success('Сервер остановлен');
    }

}