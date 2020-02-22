<?php

namespace App\Commands;

use App\Services\Message;
use App\Services\Socket;

class Server implements Command
{
    /** @var resource */
    private $stdin;

    /** @var resource */
    private $stdout;

    /** @var resource */
    private $stderr;

    public static function getName(): string
    {
        return 'Server';
    }

    public function process(): void
    {
        $this->detached();

        Message::log('Запуск сервера');

        $socket = new Socket(getenv(self::ENV_SOCKET_SERVER));
        $socket->create();

        while (true) {
            $socket->block();

            Message::log('Готов к получению данных...');

            $bucket = $socket->receive();

            Message::log("Получено {$bucket->getData()} от {$bucket->getFrom()}");

            $socket->unblock();

            $socket->send('OK', $bucket->getFrom());

            Message::log('Запрос выполнен');
        }

        $socket->close();
    }

    /**
     * Отвязываем скрипт от консоли.
     */
    private function detached(): void
    {
        if (pcntl_fork()) {
            exit();
        }

        posix_setsid();

        $dir = dirname(dirname(__DIR__)) . '/' . getenv(self::ENV_LOG_DIR);
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        fclose(STDIN);
        fclose(STDOUT);
        fclose(STDERR);

        $this->stdin = fopen('/dev/null', 'r');
        $this->stdout = fopen($dir . '/server.log', 'ab');
        $this->stderr = fopen($dir . '/server_error.log', 'ab');
    }
}
