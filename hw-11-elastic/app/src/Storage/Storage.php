<?php

namespace Storage;

use Config\Config;
use Singleton\Singleton;

class Storage extends Singleton
{
    private $storage;

    public const STORAGE_MODE_CONFIG_KEY = 'storage_mode';
    public const DB_HOST_CONFIG_KEY = 'db_host';

    public function init()
    {
        $storageMode = Config::getInstance()->getItem(self::STORAGE_MODE_CONFIG_KEY);

        $this->setStorage($storageMode);
    }

    private function setStorage(string $storageMode)
    {
        if ($storageMode === ElasticSearch::STORAGE_NAME) {
            $this->storage = new ElasticSearch();
        }
    }

    public function getStorage()
    {
        return $this->storage;
    }
}