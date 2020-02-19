<?php

namespace App\Services;

use App\Commands\Client;
use App\Commands\Command;
use App\Commands\Server;

class Cli
{
    private const OPTION_SERVER = 'server';
    private const OPTION_CLIENT = 'client';

    /** @var array */
    private $options = [];

    /**
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

        if (isset($this->options[self::OPTION_CLIENT])) {
            return new Client();
        }

        throw new \DomainException($this->getHowUse());
    }

    private function read(): void
    {
        $shortOpts = '';
        $longOpts = [
            self::OPTION_SERVER,
            self::OPTION_CLIENT,
        ];

        $this->options = getopt($shortOpts, $longOpts);
    }

    private function getHowUse(): string
    {
        $msg = 'Неправильный синтаксис команды!' . PHP_EOL;
        $msg .= '  Запуск сервера' . PHP_EOL;
        $msg .= '  php app.php --server' . PHP_EOL;
        $msg .= '  Запуск клиента' . PHP_EOL;
        $msg .= '  php app.php --client';

        return $msg;
    }
}
