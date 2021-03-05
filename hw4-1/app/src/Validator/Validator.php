<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\Rules\RuleInterface;
use App\Validator\Rules\Rules;
use UnexpectedValueException;

class Validator
{

    private static string $errorMessage;

    public static function validate($value, array $rules): bool
    {
        foreach ($rules as $rule) {
            if (!$rule) {
                continue;
            }

            [$ruleName, $ruleParam] = RuleParser::parse($rule);

            $rule = static::createRule($ruleName, $ruleParam);

            if (!$rule->validate($value)) {
                static::$errorMessage = $rule->getErrorMessage();

                return false;
            }
        }

        return true;
    }

    private static function createRule(string $ruleName, $ruleParam): RuleInterface
    {
        $ruleClassName = static::getRuleClassName($ruleName);

        return ($ruleParam ? new $ruleClassName($ruleParam) : new $ruleClassName());
    }

    private static function getRuleClassName(string $ruleName): string
    {
        $rules = Rules::get();

        if (empty($rules[$ruleName])) {
            throw new UnexpectedValueException("Правило {$ruleName} не найдено");
        }

        return $rules[$ruleName];
    }

    public static function getErrorMessage(): string
    {
        return static::$errorMessage;
    }

}