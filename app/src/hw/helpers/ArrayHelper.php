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
        $dbName = $_ENV['NO_SQL_DB'];

        switch ($dbName){
            case $db::MONGO_DB:
                return self::formatForMongoDB($data);
            case $db::ELASTIC_SEARCH:
                return self::formatForES($data);
            default:
                throw new \Exception('invalid type of DB');
        }
    }

    private static function formatForMongoDB(array $data)
    {
        return $data;
    }

    private static function formatForES(array $data)
    {
        return [
            'index' => $data['tableName'],
            'id' => $data['id'],
            'body' => [
                'title' => $data['title'],
                'description' => $data['description'],
                'viewCount' => $data['viewCount'],
                'videoCount' => $data['videoCount'],
                'subscriberCount' => $data['subscriberCount']
            ]
        ];
    }

    /**
     * @param $data
     * @param $index
     * @return array|bool
     */
    public static function index($data, $index)
    {
        foreach ($data as $key => $value) {
            if ($key === $index) {
                return [
                    $value => $data
                ];
            }
        }

        return false;
    }
}