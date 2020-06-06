<?php
namespace hw6;

interface RuleInterface
{
    public static function check(string $email): bool;
}