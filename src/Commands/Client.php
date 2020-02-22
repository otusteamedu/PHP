<?php

namespace App\Commands;

use App\Services\Message;
use App\Services\Socket;

class Client implements Command
{
    public static function getName(): string
    {
        return 'Client';
    }

    public function process(): void
    {
        Message::info('Запуск клиента');

        $addressTo = getenv(self::ENV_SOCKET_SERVER);
        if (empty($addressTo)) {
            throw new \RuntimeException('Неверный путь к сокету сервера.');
        }

        $socket = new Socket(getenv(self::ENV_SOCKET_CLIENT));
        $socket->create();

        Message::info('Введите сообщение (для выхода \'exit\'):');

        $message = $this->readMessage();

        while ($message !== self::COMMAND_EXIT) {
            if (empty($message)) {
                Message::error('Сообщение не может быть пустым!');
                $message = $this->readMessage();

                continue;
            }

            try {
                $socket->send($message, $addressTo);
                $socket->block();

                $bucket = $socket->receive();

                Message::info("Получено {$bucket->getData()} от {$bucket->getFrom()}");
            } catch (\RuntimeException $e) {
                Message::error($e->getMessage());
            } finally {
                $message = $this->readMessage();
            }
        }

        $socket->close();

        Message::info('Клиент закрыт!');
    }

    private function readMessage(): string
    {
        return readline('> ');
    }
}
