<?php
namespace hw6\Rule;

use hw6\RuleInterface;

class PHPFilter implements RuleInterface
{
    public static function check(string $email): bool
    {
        $result = filter_var($email, FILTER_VALIDATE_EMAIL);

        return !empty($result);
    }
}