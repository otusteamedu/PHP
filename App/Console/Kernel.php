<?php


namespace App\Console;


use Illuminate\Console\Application;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class Kernel extends \Laravel\Lumen\Console\Kernel
{
    private bool $commandsLoaded = false;

    protected function getCommands()
    {
        if (!$this->commandsLoaded) {
            $this->load();
            $this->commandsLoaded = true;
        }

        return $this->commands;
    }

    private function load(): void
    {
        $path = __DIR__ . DIRECTORY_SEPARATOR . 'Commands';
        $this->commands = collect((new Finder())->in($path)->files())
            ->map(fn(\SplFileInfo $command) => $this->app->getNamespace() . str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($command->getRealPath(), realpath($this->app->path()) . DIRECTORY_SEPARATOR
                    )))
            ->filter(fn(string $class) => !(new \ReflectionClass($class))->isAbstract())
            ->toArray();
    }
}