<?php


namespace App\ConsoleCommands\Commands;


use App\Services\RabbitMQ\Manager;
use App\Services\ServiceContainer\AppServiceContainer;

class RunRabbitMQ  implements Command
{
    public function run(array $argv): string
    {
        $manager = AppServiceContainer::getInstance()->resolve(Manager::class);
        $manager->listen();

        return PHP_EOL . 'RabbitMQ stopped.';
    }
}