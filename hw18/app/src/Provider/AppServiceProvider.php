<?php

declare(strict_types=1);

namespace App\Provider;

use App\Console\Console;
use App\Console\ConsoleInterface;
use App\Service\Hydrator\Hydrator;
use App\Service\Hydrator\HydratorInterface;

class AppServiceProvider extends AbstractServiceProvider
{
    protected array $bindings = [
        ConsoleInterface::class  => Console::class,
        HydratorInterface::class => Hydrator::class,
    ];

    protected function addMoreBindings(): void
    {

    }
}