<?php


namespace App\Core;

use App\ConsoleCommands\CommandManager;

class Console
{
    private array $argv;
    private CommandManager $commandManager;

    public function __construct(array $argv)
    {
        $this->argv = $argv;
        $this->commandManager = new CommandManager();
    }

    public function getResponse() : string
    {
        $command = $this->argv[1] ?? '';

        if($this->commandManager->isCommandExist($command)){
            return $this->commandManager->getInstance($command)->run($this->argv);
        }

        return 'Command Not Found' . PHP_EOL;
    }
}