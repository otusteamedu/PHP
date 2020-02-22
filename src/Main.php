<?php

namespace App;

use App\Services\Cli;
use App\Services\Message;
use Symfony\Component\Dotenv\Dotenv;

class Main
{
    /** @var \App\Services\Cli */
    private $cli;

    public function __construct()
    {
        $this->init();

        $this->cli = new Cli();
    }

    /**
     * Запускаем приложение.
     */
    public function run(): void
    {
        try {
            $command = $this->cli->getCommand();
            $command->process();
        } catch (\Exception $e) {
            Message::error($e->getMessage());
        }
    }

    /**
     * Инициализируем приложение.
     */
    private function init(): void
    {
        if (!extension_loaded('sockets')) {
            throw new \RuntimeException('Не загружено расширение PHP sockets.');
        }

        if (file_exists(dirname(__DIR__) . '/.env')) {
            (new Dotenv(true))->load(dirname(__DIR__) . '/.env');
        } else {
            throw new \RuntimeException('Не определен файл окружения .env.');
        }
    }
}
