<?php


namespace Repetitor202\Application\Clients\SQL;


use Exception;
use Repetitor202\Application\Clients\SQL\Connections\MongoDbConnection;

class MongoDbQuery extends SqlQuery
{
    public const STORAGE_NAME = 'MongoDB';

    final private static function getTableConnection(string $table)
    {
        return MongoDbConnection::getTableConnection($table);
    }

    public static function selectItems(string $table, array $params = []): array
    {
        $tableConnection = self::getTableConnection($table);

        $queryParams = [];
        $options = $params['options'] ?? [];

        if (isset($options['skip'])) {
            $queryParams['skip'] = $options['skip'];
        }

        if (isset($options['limit'])) {
            $queryParams['limit'] = $options['limit'];
        }

        if (isset($options['sort'])) {
            $queryParams['sort'] = [];

            foreach ($options['sort'] as $sorter) {
                if (isset($sorter['col']) && isset($sorter['ascDesc'])) {
                    $ascDesc = ($sorter['ascDesc'] === 'asc') ? 1 : -1;
                    $queryParams['sort'][$sorter['col']] = $ascDesc;
                }
            }
        } else {
            $queryParams['sort'] = [
                '_id' => -1,
            ];
        }

        $items = $tableConnection->find([], $queryParams);
        $itemsArray = [];

        foreach ($items as $item) {
            $itemsArray[] = $item;
        }

        return $itemsArray;
    }

    public static function findById(string $table, $identificator): ?array
    {
        $tableConnection = self::getTableConnection($table);

        $response = $tableConnection->findOne(['_id' => $identificator]);
        if (is_null($response)) {
            return null;
        }

        $responseSerialized = (array) $response->jsonSerialize();
        if (empty($responseSerialized)) {
            return null;
        }

        return $responseSerialized;
    }

    public static function createOneItem(string $table, array $params, $identificator = null): bool
    {
        $tableConnection = self::getTableConnection($table);

        if (! is_null($identificator)) {
            $params['_id'] = $identificator;
        }

        try {
            $insertOneResult = $tableConnection->insertOne($params);
            if ($insertOneResult->getInsertedCount()) {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }

        return false;
    }

    public static function updateOneItem(string $table, array $params, $identificator): bool
    {
        // TODO: Implement updateOneItem() method.
    }

    public static function createUpdateOneItem(string $table, array $params, $identificator): bool
    {
        // TODO: Implement createUpdateOneItem() method.
    }

    public static function deleteById(string $table, $identificator): bool
    {
        $tableConnection = self::getTableConnection($table);

        $result = $tableConnection->deleteOne(
            ['_id' => $identificator],
        );

        if ($result->getDeletedCount()) {
            return true;
        }

        return false;
    }

    public static function deleteByParams(string $table, array $params): bool
    {
        $tableConnection = self::getTableConnection($table);

        $result = $tableConnection->deleteMany(
            $params['match']
        );

        if ($result->getDeletedCount()) {
            return true;
        }

        return false;
    }
}