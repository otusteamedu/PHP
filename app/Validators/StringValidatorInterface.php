<?php

declare(strict_types=1);

namespace App\Validators;

interface StringValidatorInterface
{
    public function validate(string $string): bool;
}
