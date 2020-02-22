<?php

namespace App\Commands;

use App\Services\Message;
use App\Services\Socket;

class Client implements Command
{
    /**
     * Выполняем команду.
     */
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

                Message::info("Статус: {$bucket->getData()}. От {$bucket->getFrom()}");
            } catch (\RuntimeException $e) {
                Message::error($e->getMessage());
            } finally {
                $message = $this->readMessage();
            }
        }

        $socket->close();

        Message::info('Клиент закрыт!');
    }

    /**
     * Принимаем сообщение из консоли.
     *
     * @return string
     */
    private function readMessage(): string
    {
        return readline('> ');
    }
}
