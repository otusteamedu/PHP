<?php

namespace Otus\Config;

class ConfigFactory
{
    public static function make(): ConfigContract
    {
        return new Config(__DIR__ . '/../../../config/database.php');
    }
}
