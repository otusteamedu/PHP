<?php


namespace Otus\Storage;

use Monolog\Logger;
use Otus\Exceptions\AppException;

class StorageFactory
{
    /**
     * @return StorageInterface
     * @throws AppException
     */
    public static function create()
    {
        switch ($_ENV['STORAGE']) {
            case RedisDAO::STORAGE_NAME:
                return new RedisDAO();
            default:
                throw new AppException('Invalid storage type',Logger::ERROR);
        }
    }
}
