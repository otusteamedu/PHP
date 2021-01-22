<?php


namespace Otushw\Storage;

class StorageFactory
{

    /**
     * @return StorageInterface
     */
    public static function create(): StorageInterface
    {
        $storageName = $_ENV['storage_name'];
        switch ($storageName) {
            case RedisDAO::STORAGE_NAME:
                return new RedisDAO();
        }
    }
}
