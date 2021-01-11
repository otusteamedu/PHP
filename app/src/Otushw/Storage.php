<?php


namespace Otushw;

use Otushw\DBSystem\ElasticSearch\ElasticSearchDAO;

class Storage
{

    /**
     * @return StorageInterface
     */
    public static function getStorage(): StorageInterface
    {
        $storageType = $_ENV['DB_SYSTEM'];
        switch ($storageType) {
            case ElasticSearchDAO::STORAGE_NAME:
                return new ElasticSearchDAO();
        }
    }
}
