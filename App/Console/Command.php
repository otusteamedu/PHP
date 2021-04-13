<?php

namespace App\Console;

use App\Console\Exceptions\CommandNotFound;

class Command
{
    private function __construct()
    {
    }

    /**
     * @throws CommandNotFound
     */
    public static function exec(): void
    {
        $parser = new Parser();
        if ($parser->getCommand() !== '') {
            $className = $parser->getCommandClassName();
            if (class_exists($className) && is_subclass_of($className, CommandContract::class)) {
                (new $className($parser->getArguments()))->handle();
            } else {
                throw new CommandNotFound($parser->getCommand());
            }
        }
    }
}