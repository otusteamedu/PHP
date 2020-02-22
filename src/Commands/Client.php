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

        $socket = new Socket(getenv('SOCKET_CLIENT'));
        $socket->create();

        $addressTo = getenv('SOCKET_SERVER');
        $message = "Message 1234";

        $socket->send($message, $addressTo);
        $socket->block();

        $bucket = $socket->receive();

        Message::info("Получено {$bucket->getData()} от {$bucket->getFrom()}");

        $socket->close();

        Message::info('Клиент закрыт!');
    }
}
