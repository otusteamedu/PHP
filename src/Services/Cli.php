<?php

namespace App\Services;

use App\Commands\Client;
use App\Commands\Command;
use App\Commands\Server;
use App\Commands\ServerStop;

class Cli
{
    private const OPTION_SERVER = 'server';
    private const OPTION_SERVER_STOP = 'server-stop';
    private const OPTION_CLIENT = 'client';

    /** @var array */
    private $options = [];

    /**
     * Роутинг.
     *
     * @return Command
     */
    public function getCommand(): Command
    {
        if (php_sapi_name() !== 'cli') {
            throw new \DomainException('Это консольное приложение.');
        }

        $this->read();

        if (isset($this->options[self::OPTION_SERVER])) {
            return new Server();
        }

        if (isset($this->options[self::OPTION_SERVER_STOP])) {
            return new ServerStop();
        }

        if (isset($this->options[self::OPTION_CLIENT])) {
            return new Client();
        }

        throw new \DomainException($this->getHowUse());
    }

    /**
     * Читаем опции команды.
     */
    private function read(): void
    {
        $shortOpts = '';
        $longOpts = [
            self::OPTION_SERVER,
            self::OPTION_SERVER_STOP,
            self::OPTION_CLIENT,
        ];

        $this->options = getopt($shortOpts, $longOpts);
    }

    /**
     * Выводим хелп.
     *
     * @return string
     */
    private function getHowUse(): string
    {
        $msg = 'Неправильный синтаксис команды!' . PHP_EOL;
        $msg .= '  Запуск сервера' . PHP_EOL;
        $msg .= '  php app.php --server' . PHP_EOL;
        $msg .= '  Остановка сервера' . PHP_EOL;
        $msg .= '  php app.php --server-stop' . PHP_EOL;
        $msg .= '  Запуск клиента' . PHP_EOL;
        $msg .= '  php app.php --client';

        return $msg;
    }
}
