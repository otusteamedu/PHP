<?php

namespace Ushakov\EmailValidator;

use Ushakov\EmailValidator\Rules\AbstractRule;
use Ushakov\EmailValidator\Rules\MXCheckRule;
use Ushakov\EmailValidator\Rules\RegexRule;

/**
 * Class EmailValidator
 * Валидатор для проверки email адреса по произвольному количеству правил, описаных в константе RULES
 */
class EmailValidator
{
    const RULES = [
        RegexRule::class,
        MXCheckRule::class,
    ];

    public static function validate(string $email)
    {
        foreach (static::RULES as $rule) {
            /* @var AbstractRule $rule */
            if (!$rule::validate($email)) {
                return false;
            }
        }
        return true;
    }
}
