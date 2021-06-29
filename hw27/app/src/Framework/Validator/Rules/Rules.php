<?php

declare(strict_types=1);

namespace App\Framework\Validator\Rules;

class Rules
{
    public static function get(): array
    {
        return [
            'required' => RequiredRule::class,
            'date'     => DateRule::class,
        ];
    }
}