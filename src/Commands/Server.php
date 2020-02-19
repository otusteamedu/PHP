<?php

namespace App\Commands;

use App\Services\Message;
use App\Services\Socket;

class Server implements Command
{
    public static function getName(): string
    {
        return 'Server';
    }

    public function process(): void
    {
        Message::info('Запуск сервера');

        $socket = new Socket(self::getName());
        $socket->create();

        while (true) {
            $socket->block();

            Message::info('Готов к получению данных...');

            $bucket = $socket->receive();

            Message::info("Получено {$bucket->getData()} от {$bucket->getFrom()}");

            $socket->unblock();

            $socket->send($bucket->getData() . "->Response", $bucket->getFrom());

            Message::info('Запрос выполнен');
        }

        $socket->close();
    }
}
