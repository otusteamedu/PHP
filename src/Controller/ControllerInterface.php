<?php

declare(strict_types=1);

namespace HomeWork\Controller;

interface ControllerInterface
{
    public function run(?string $message): void;
}
