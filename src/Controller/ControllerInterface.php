<?php

declare(strict_types=1);

namespace Controller;

interface ControllerInterface
{
    public function run(?string $message): void;
}