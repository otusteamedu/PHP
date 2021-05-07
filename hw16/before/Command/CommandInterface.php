<?php

declare(strict_types=1);

namespace App\Command;

interface CommandInterface
{

    public function execute(): void;

}