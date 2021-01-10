<?php
namespace VideoPlatform\helpers;

use VideoPlatform\interfaces\DBInterface;

class ArrayHelper
{
    /**
     * @param DBInterface $db
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public static function getCorrectFormat(DBInterface $db, array $data)
    {
        $className = get_class($db);

        switch ($className){
            case $db::ELASTIC_SEARCH:
                $data = self::formatForMongoDB($data);
                break;
            case $db::MONGO_DB:
                $data = self::formatForES($data);
                break;
            default:
                throw new \Exception('invalid type of DB');
        }

        return $data;
    }

    private static function formatForMongoDB(array $data)
    {
        return $data;
    }

    private function formatForES(array $data)
    {
        return $data;
    }
}