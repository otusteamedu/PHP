<?php

namespace App\Storage;

use App\Config\Config;
use Exception;
use Symfony\Component\Yaml\Exception\ParseException;

class MysqlConfigValidator
{
    public static function validate($keys): void
    {
        foreach ($keys as $item) {
            $dbConfig = Config::getInstance()->getItem(Storage::DB_CONFIG_KEY);

            if (!isset($dbConfig[$item])) {
                throw new Exception("Database config '$item' is not found");
            }
        }
    }
}