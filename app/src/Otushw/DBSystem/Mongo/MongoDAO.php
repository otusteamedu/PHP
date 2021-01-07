<?php


namespace Otushw\DBSystem\Mongo;

use Otushw\DBSystem\NoSQLDAO;
use Otushw\DBSystem\DocumentDTO;
use Exception;

class MongoDAO extends NoSQLDAO
{
    const DB_NAME = 'stats';

    private $client;
    private $database;
    private $collection;

    public function __construct(DocumentDTO $doc)
    {
        parent::__construct($doc);
        $client = new \MongoDB\Client($_ENV['DB_HOST']);
        $this->client = $client;

        $database = $client->{self::DB_NAME};
        $this->database = $database;
    }

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
    public function getItems($limit = 10, $offset = 0): array
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

    public function getSumField($fieldName)
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
        return $result;
    }

    public function read($id): array
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

    public function update($id, array $source): bool
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

    public function delete($id): bool
    {
        $result = $this->collection->deleteOne(
            ['_id' => $id],
        );
        if ($result->getDeletedCount()) {
            return true;
        }
        return false;
    }

    public function createDocStruct()
    {
        return $this->createCollectionStruct();
    }

    private function createCollectionStruct()
    {
        try {
            $this->database->createCollection(
                $this->documentName,
                ['validator' =>  $this->doc->getDocumentStruct()]
            );
            $this->collection = $this->database->selectCollection($this->documentName);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    public function existDocStruct()
    {
        return $this->existCollectionStruct();
    }

    private function existCollectionStruct()
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
