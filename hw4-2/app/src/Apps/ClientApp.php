<?php

declare(strict_types=1);

namespace App\Apps;

use App\Console\Console;
use App\Socket\Socket;
use Exception;

class ClientApp
{

    private Socket $socket;

    public function __construct(Socket $socket)
    {
        $this->socket = $socket;
    }

    public function start(): void
    {
        try {
            $this->socket->connection();
            Console::success('Клиентское приложение запущено');

            $data = Console::waitingForUserInput('Введите текст сообщения: ');

            $this->socket->write($data);

            if ($response = $this->socket->read()) {
                Console::info("Получен ответ: {$response}");
            }
        } catch (Exception $e) {
            Console::lineBreak();
            Console::error($e->getMessage());
        } finally {
            $this->stop();
        }
    }

    public function stop(): void
    {
        $this->socket->close();

        Console::success('Клиентское приложение остановлено');
    }

}