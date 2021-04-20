<?php

declare(strict_types=1);

namespace App\DIContainer;

interface ContainerInterface
{

    public function get(string $abstract): object;

    public function has(string $abstract): bool;

    public function set(string $abstract, $concreteImpl = null): void;

}