<?php

namespace Ushakov\EmailValidator\Rules;

abstract class AbstractRule
{
    abstract public static function validate(string $email): bool;
}
