<?php declare(strict_types=1);

namespace Repository;

use MongoDB\Driver\Exception\InvalidArgumentException;
use Service\Database\DatabaseInterface;

abstract class AbstractRepository implements RepositoryInterface
{
    protected DatabaseInterface $database;

    private string $collectionName;

    public function __construct(DatabaseInterface $database, string $collectionName)
    {
        $this->collectionName = $collectionName;
        $this->database = $database;
        $this->database->setCollectionName($this->collectionName);
    }

    public function findOne(string $id): ?object
    {
        try {
            return $this->database->getOne($id);
        } catch (InvalidArgumentException $exception) {
            return null;
        }
    }

    public function find(array $filter): array
    {
        return $this->database->get($filter);
    }

    public function saveOne(object $object): string
    {
        return $this->database->saveOne($object);
    }

    public function deleteOne(string $id): int
    {
        return $this->database->deleteOne($id);
    }
}
