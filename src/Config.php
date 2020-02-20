<?php

namespace App;

use InvalidArgumentException;

final class Config
{
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
        if (null !== $default_value) {
            return $default_value;
        }
        throw new InvalidArgumentException('Unknown config var name');
    }
}
