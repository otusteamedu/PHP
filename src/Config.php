<?php

namespace App;

use InvalidArgumentException;

final class Config
{
    private static array $ini_file_vals = [];

    /**
     * @param string $name
     * @param mixed $default_value
     * @return mixed
     */
    public static function get(string $name, $default_value = null): string
    {
        if (!$name) {
            throw new InvalidArgumentException('Empty config var name');
        }
        $value = getenv(strtoupper($name));
        if (false !== $value) {
            return $value;
        }
        if (!self::$ini_file_vals) {
            self::$ini_file_vals = parse_ini_file(__DIR__ . '/../app.ini');
        }
        $value = self::$ini_file_vals[$name] ?? $default_value;
        if (null !== $value) {
            return $value;
        }
        throw new InvalidArgumentException('Unknown config var name');
    }
}
