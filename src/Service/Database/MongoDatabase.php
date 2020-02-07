<?php declare(strict_types=1);

namespace Service\Database;

use MongoDB\BSON\ObjectId;
use MongoDB\Client;
use MongoDB\Collection;

class MongoDatabase implements DatabaseInterface
{
    private string $database;
    private string $collectionName;
    private Client $client;

    public function __construct()
    {
        $this->client = new Client('mongodb://root:password@mongo:27017/');
        $this->database = 'admin';
    }

    public function setCollectionName(string $collectionName): void
    {
        $this->collectionName = $collectionName;
    }

    public function saveOne(object $object): string
    {
        $collection = $this->client->selectCollection($this->database, $this->collectionName);
        $result = $collection->insertOne($this->prepareDocument($object));

        return $result->getInsertedId()->__toString();
    }

    public function getOne(string $id): ?object
    {
        $collection = $this->client->selectCollection($this->database, $this->collectionName);

        return $collection->findOne(['_id' => new ObjectId($id)]);
    }

    public function get(array $filter): array
    {
        $collection = $this->client->selectCollection($this->database, $this->collectionName);
        $cursor = $collection->find($filter);

        return $cursor->toArray();
    }

    public function deleteOne(string $id): int
    {
        $collection = $this->client->selectCollection($this->database, $this->collectionName);

        return $collection->deleteOne(['_id' => new ObjectId($id)])->getDeletedCount();
    }

    public function getCollection(): Collection
    {
        return $this->client->selectCollection($this->database, $this->collectionName);
    }

    private function prepareDocument(object $object): array
    {
        return json_decode(json_encode($object), true);
    }
}
