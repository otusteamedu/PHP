<?php


namespace Repetitor202\Application\helpers;


use Repetitor202\Application\AppException;

class Helper
{
    public static function keyMustExist(string $key, array $arr): void
    {
        if (! array_key_exists($key, $arr)) {
            AppException::keyIsRequired($key);
        }
    }
}