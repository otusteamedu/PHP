<?php


namespace App\ConsoleCommands;


use App\ConsoleCommands\Commands\Command;
use App\ConsoleCommands\Commands\Migrate;

class CommandManager
{
    public const MIGRATE_COMMAND = 'migrate';
    public const COMMANDS = [
        self::MIGRATE_COMMAND => Migrate::class,
    ];

    public function getInstance(string $command) : Command
    {
        if(false === $this->isCommandExist($command)){
            throw new \RuntimeException('Command ' . $command . ' not exist');
        }

        $commandClass = self::COMMANDS[$command];

        if(!class_exists($commandClass)){
            throw new \RuntimeException('Class ' . $commandClass . ' not exist');
        }

        return new $commandClass;
    }

    public function isCommandExist(string $command) : bool
    {
        return (bool) (self::COMMANDS[$command] ?? false);
    }
}