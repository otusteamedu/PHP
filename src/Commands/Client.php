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

        $socket = new Socket($this->getName());
        $socket->create();

        // todo: получить данные сервера из ENV
        $serverAddress = '/var/run/chat/server.sock';
        $message = "Message 1234";

        $socket->send($message, $serverAddress);
        $socket->block();

        $bucket = $socket->receive();

        Message::info("Получено {$bucket->getData()} от {$bucket->getFrom()}");

        $socket->close();

        Message::info('Клиент закрыт!');
    }
}
