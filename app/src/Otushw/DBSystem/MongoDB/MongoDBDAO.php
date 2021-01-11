<?php


namespace Otushw\DBSystem\MongoDB;

use MongoDB\Client;
use MongoDB\Collection;
use MongoDB\Database;
use Otushw\DBSystem\NoSQLDAO;
use Exception;

class MongoDBDAO extends NoSQLDAO
{
    const DB_NAME = 'stats';
    const STORAGE_NAME = 'MongoDB';

    private Client $client;
    private Database $database;
    private Collection $collection;

    public function __construct()
    {
        $client = new Client($_ENV['DB_HOST']);
        $this->client = $client;

        $database = $client->{self::DB_NAME};
        $this->database = $database;
        parent::__construct();
    }

    /**
     * @param array $source
     *
     * @return bool
     */
    public function create(array $source): bool
    {
        $source['_id'] = $source['id'];
        try {
            $insertOneResult = $this->collection->insertOne($source);
            if ($insertOneResult->getInsertedCount()) {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
        return false;
    }

    /**
     * @param int $limit
     * @param int $offset
     *
     * @return array
     * @throws Exception
     */
    public function getItems(int $limit = 10, int $offset = 0): array
    {
        $response = $this->collection->find(
            [],
            [
                'skip' => $offset,
                'limit' => $limit
            ]
        );
        $result = [];
        foreach ($response as $row) {
            $row = (array) $row->jsonSerialize();
            $buf = [];
            foreach ($this->struct as $item) {
                $buf[$item] = $row[$item];
            }
            $result[] = $buf;
        }

        return $result;
    }

    /**
     * @return int
     * @throws Exception
     */
    public function getCount(): int
    {
        return $this->collection->count();
    }

    /**
     * @param string $fieldName
     *
     * @return int
     */
    public function getSumField(string $fieldName): int
    {
        $cursor = $this->collection->aggregate(
            [
                [
                    '$group' => [
                        '_id' => 'null',
                        'total' => ['$sum' => '$'.$fieldName]
                    ]
                ],
            ]
        );

        $result = 0;
        foreach ($cursor as $item) {
            $result = $item->jsonSerialize()->total;
        }
        return (int) $result;
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function read(int $id): array
    {
        $response = $this->collection->findOne(['_id' => $id]);
        if (empty($response)) {
            return [];
        }
        $response = (array) $response->jsonSerialize();
        $result = [];
        foreach ($this->struct as $item) {
            $result[$item] = $response[$item];
        }
        return $result;
    }

    /**
     * @param int   $id
     * @param array $source
     *
     * @return bool
     */
    public function update(int $id, array $source): bool
    {
        $result = $this->collection->updateOne(
            ['_id' => $id],
            ['$set' => $source]
        );
        if ($result->getModifiedCount() || $result->getMatchedCount()) {
            return true;
        }
        return false;
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        $result = $this->collection->deleteOne(
            ['_id' => $id],
        );
        if ($result->getDeletedCount()) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function createDocStruct(): bool
    {
        return $this->createCollectionStruct();
    }

    /**
     * @return bool
     */
    private function createCollectionStruct()
    {
        try {
            $this->database->createCollection(
                $this->documentName,
                ['validator' =>  $this->generateCollectionStruct()]
            );
            $this->collection = $this->database->selectCollection($this->documentName);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * @return array
     */
    private function generateCollectionStruct(): array
    {
        $result = [];
        foreach ($_ENV['SCHEMA'] as $field => $dataType) {
            if ($dataType == 'string') {
                $type = 'string';
            }
            if ($dataType == 'integer') {
                $esType = 'int';
            }
            $result[$field] = ['$type' => $type];
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function existDocStruct(): bool
    {
        return $this->existCollectionStruct();
    }

    /**
     * @return bool
     */
    private function existCollectionStruct(): bool
    {
        foreach ($this->database->listCollections() as $collection) {
            if ($collection->getName() == $this->documentName) {
                $this->collection = $this->database->selectCollection($this->documentName);
                return true;
            }
        }
        return false;
    }
}
