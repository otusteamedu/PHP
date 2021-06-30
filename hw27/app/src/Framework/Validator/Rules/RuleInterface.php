<?php

declare(strict_types=1);

namespace App\Framework\Validator\Rules;

interface RuleInterface
{
    public function validate($value): bool;

    public function getErrorMessage(): string;
}