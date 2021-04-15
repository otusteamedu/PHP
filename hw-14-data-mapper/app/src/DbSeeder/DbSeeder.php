<?php

namespace App\DbSeeder;

use App\Config\Config;
use App\Storage\Storage;
use Exception;

class DbSeeder
{
    public const DB_TABLES_KEY = 'tables';

    public static function seed (): bool
    {
        $tables = Config::getInstance()->getItem(Storage::DB_CONFIG_KEY)[self::DB_TABLES_KEY];

        if (is_array($tables) && !empty($tables)) {
            $success = true;

            foreach ($tables as $table) {
                $fullSeederName = self::getFullSeederName($table);

                $success = (new $fullSeederName())->execute();
            }

            return $success;
        }
        else {
            throw new Exception('empty tables config');
        }
    }

    private static function getFullSeederName (string $table): string
    {
        $className = ucfirst($table) . 'TableSeeder';

        return '\App\DbSeeder\Seeders\\' . $className;
    }
}