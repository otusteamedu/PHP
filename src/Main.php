<?php

namespace App;

use App\Services\Cli;

class Main
{
    /** @var \App\Services\Cli */
    private $cli;

    public function __construct()
    {
        $this->init();

        $this->cli = new Cli();
    }

    public function run(): void
    {
        try {
            $command = $this->cli->getCommand();
            $command->process();
        } catch (\Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }
    }

    private function init(): void
    {
        if (!extension_loaded('sockets')) {
            throw new \RuntimeException('Не загружено расширение PHP sockets.');
        }
    }
}
