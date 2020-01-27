<?php

namespace Ushakov\EmailValidator\Rules;

/**
 * Class RegexRule
 * Проверка email с помощью регулярного выражения встроенной функцией php
 *
 * @package Ushakov\EmailValidator\Rules
 */
class RegexRule extends AbstractRule
{
    public static function validate(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
