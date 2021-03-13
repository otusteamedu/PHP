<?php


namespace Repetitor202\Application\Clients\SQL;


use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Exception;

class ElasticsearchClient extends SqlClient
{
    public const STORAGE_NAME = 'Elasticsearch';
    protected static ?Client $client = null;

    final private function __construct(){}
    final private function __clone(){}
    final private function __wakeup(){}

    final private static function getClient(): ?Client
    {
        if (self::$client === null) {
            self::$client = ClientBuilder::create()
                ->setHosts([$_ENV['ELASTIC_SEARCH_HOST']])
                ->build();
        }

        return self::$client;
    }

    public static function selectItems(string $table, array $params = []): ?array
    {
        $queryParams = [
            'index' => $table,
        ];

        $body = [];
        $options = $params['options'] ?? [];

        if (count($options)) {
            if (isset($options['skip'])) {
                $queryParams['from'] = $options['skip'];
            }

            if (isset($options['limit'])) {
                $queryParams['size'] = $options['limit'];
            }

            if (isset($options['sort'])) {
                $body['sort'] = [];
                foreach ($options['sort'] as $sorter) {
                    if (isset($sorter['col']) && isset($sorter['ascDesc'])) {
                        $body['sort'][$sorter['col']] = ['order' => $sorter['ascDesc'],];
                    }
                }
            }
        }

        $queryParams['body'] = $body;

        try {
            return self::getClient()->search($queryParams);
        } catch (Exception $e) {
            return null;
        }
    }

    public static function findById(string $table, $identificator): ?array
    {
        $queryParams = [
            'index' => $table,
            'id' => $identificator,
        ];

        try {
            return self::getClient()->get($queryParams);
        } catch (Exception $e) {
            return null;
        }
    }

    public static function createOneItem(string $table, array $params, $identificator = null): bool
    {
        $queryParams = [
            'index' => $table,
            'body' => $params,
        ];

        if (! is_null($identificator)) {
            $queryParams['id'] = $identificator;
        }

        try {
            $insertResult = self::getClient()->index($queryParams);
            if (is_array($insertResult)) {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }

        return false;
    }

    public static function updateOneItem(string $table, array $params, $identificator): bool
    {
        return self::createOneItem($table, $params, $identificator);
    }

    public static function createUpdateOneItem(string $table, array $params, $identificator): bool
    {
        return self::createOneItem($table, $params, $identificator);
    }

    public static function deleteById(string $table, $identificator): bool
    {
        $queryParams = [
            'index' => $table,
            'id'    => $identificator,
        ];

        try {
            $response = self::getClient()->delete($queryParams);
        } catch (Exception $e) {
            return false;
        }
        if (!empty($response['result']) && $response['result'] === 'deleted') {
            return true;
        }

        return false;
    }

    public static function deleteByParams(string $table, array $params): bool
    {
        $queryParams = [
            'index' => $table,
            'body'  => [
                'query' => [
                    'match' => $params['match'],
                ],
            ],
        ];

        try {
            $response = self::getClient()->deleteByQuery($queryParams);
        } catch (Exception $e) {
            return false;
        }
        if (!empty($response['deleted']) && (int) $response['deleted'] > 0) {
            return true;
        }

        return false;
    }
}