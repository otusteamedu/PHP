<?php

declare(strict_types=1);

namespace App\Framework\Validator;

class RuleParser
{
    public static function parse(string $rule): array
    {
        return [
            static::extractRuleName($rule),
            static::extractRuleParam($rule),
        ];
    }

    private static function extractRuleName(string $rule): string
    {
        return explode(':', $rule)[0];
    }

    private static function extractRuleParam(string $rule): string
    {
        $parts = explode(':', $rule);

        return (!empty($parts[1]) ? $parts[1] : '');
    }
}