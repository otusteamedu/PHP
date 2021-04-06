<?php

namespace App\Storage;

use App\Config\Config;
use App\Singleton\Singleton;

class Storage extends Singleton
{
    private NoSQLStorage $storage;

    public const STORAGE_CONFIG_KEY      = 'storage';
    public const DB_HOST_CONFIG_KEY      = 'db_host';
    public const STORAGE_MODE_CONFIG_KEY = 'storage_mode';

    public function init ()
    {
        $storageMode = Config::getInstance()->getItem(self::STORAGE_CONFIG_KEY)[self::STORAGE_MODE_CONFIG_KEY];

        $this->setStorage($storageMode);
    }

    private function setStorage (string $storageMode)
    {
        if ($storageMode === RedisStorage::STORAGE_NAME) {
            $this->storage = new RedisStorage();
        }
        if ($storageMode === MongoStorage::STORAGE_NAME) {
            $this->storage = new MongoStorage();
        }
    }

    public function getStorage ()
    {
        return $this->storage;
    }
}