<?php


namespace Otushw;

use Otushw\DBSystem\ElasticSearch\ElasticSearchDAO;
use Otushw\DBSystem\MongoDB\MongoDBDAO;

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
            case MongoDBDAO::STORAGE_NAME:
                return new MongoDBDAO();
        }
    }
}
