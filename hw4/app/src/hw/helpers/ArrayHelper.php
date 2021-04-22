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
    public static function getCorrectFormat(DBInterface $db, array $data): array
    {
        $dbTypeName = $_ENV['NO_SQL_DB'];

        switch ($dbTypeName){
            case $db::ELASTIC_SEARCH:
                return self::formatForES($data);
            default:
                throw new \Exception('invalid type of DB');
        }
    }

    private static function formatForES(array $data)
    {
        return [
            'index' => $data['tableName'],
            'id' => $data['id'],
            'body' => $data
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

    public static function getColumn(array $array, string $column): array
    {
        $result = [];

        foreach ($array as $item) {
            foreach ($item as $key => $value) {
                if ($key == $column) {
                    $result[] = $value;
                }
            }
        }

        return $result;
    }
}
