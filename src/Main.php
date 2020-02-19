<?php

namespace App;

use App\Services\Cli;

class Main
{
    /** @var Cli */
    private $cli;

    public function __construct()
    {
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
}
