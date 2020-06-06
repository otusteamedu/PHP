<?php
namespace hw6\Rule;

use hw6\RuleInterface;

class MXRecord implements RuleInterface
{
    public static function check(string $email): bool
    {
        $parts = explode('@', $email);
        $hostname = end($parts);

        $mxhosts = [];
        getmxrr($hostname, $mxhosts);

        return !empty($mxhosts);
    }
}