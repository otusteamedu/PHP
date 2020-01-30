<?php

namespace Repository;

use Core\AppConfig;
use Filter\MongoFilter;
use MongoDB\Client;
use MongoDB\Collection;
use MongoDB\Driver\Exception\BulkWriteException;
use MongoDB\Model\BSONDocument;

abstract class MongoRepository extends CommonRepository
{
    /**
     * @var Collection $collection
     */
    protected static Collection $collection;

    /**
     * @var array $indexes
     */
    protected static array $indexes = [];

    /**
     * @var Client
     */
    private static Client $client;

    /**
     * MongoRepository constructor.
     * @param string|array|BSONDocument|null $init
     */
    public function __construct($init = null)
    {
        if (is_string($init)) {
            $entities = static::get(new MongoFilter($init));
            $this->init($entities[0] ?? null);
        } elseif ($init instanceof BSONDocument) {
            $this->buildFromDocument($init);
        } elseif (is_array($init)) {
            $this->buildFromArray($init);
        }
    }

    /**
     * @param AppConfig $appConfig
     */
    public static function initStore(AppConfig $appConfig)
    {
        self::$client = new Client($appConfig->getMongoDbUrl());
        static::$collection = self::$client->{$appConfig->getMongoDbName()}->{static::class};
        $indexes = static::$collection->listIndexes();
        if (empty($indexes) && !empty(static::$indexes)) {
            static::$collection->createIndexes(static::$indexes);
        }
    }

    /**
     * @param MongoFilter $filter
     * @return static[]
     */
    public static function get($filter): array
    {
        return array_map(function (BSONDocument $document) {
            return new static($document);
        }, static::$collection->find($filter->fetch())->toArray());
    }

    /**
     * @param MongoFilter $filter
     * @return array[]
     */
    public static function fetchList($filter): array
    {
        return array_map(function (MongoRepository $entity) {
            return $entity->fetchDocument();
        }, static::get($filter));
    }

    /**
     * @param MongoFilter $filter
     * @return int
     */
    public static function deleteCollection($filter): int
    {
        $res = static::$collection->deleteMany($filter->fetch());
        return $res->getDeletedCount();
    }

    /**
     * @return bool
     * @throws BulkWriteException
     */
    public function create(): bool
    {
        try {
            $res = static::$collection->insertOne($this->fetchDocument());
            return ($this->exists = !empty($this->id = "{$res->getInsertedId()}"));
        } catch (BulkWriteException $e) {
            $indexCollision = $this->replaceUniqueIndexes();
            $res = static::$collection->replaceOne($indexCollision, $this->fetchDocument());
            return ($this->exists = !empty($this->id = "{$res->getMatchedCount()}"));
        }
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        $filter = new MongoFilter($this->id);
        return static::$collection->updateOne($filter->fetch(), $this->fetchDocument())->getModifiedCount() > 0;
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $filter = new MongoFilter($this->id);
        return static::$collection->deleteOne($filter->fetch())->getDeletedCount() > 0;
    }

    /**
     * @param static[] $collection
     */
    public static function createCollection(array $collection)
    {
        try {
            static::$collection->insertMany(array_map(function (MongoRepository $entity) {
                return $entity->fetchDocument();
            }, $collection));
        } catch (BulkWriteException $e) {
            foreach ($collection as $entity) {
                $entity->create();
            }
        }
    }

    /**
     * @return array
     */
    public function fetchDocument(): array
    {
        $document = [];
        foreach (get_object_vars($this) as $propName => $propValue) {
            if ($propName === "exists") continue;
            if ((!empty($propValue) XOR is_bool($propValue)) OR is_int($propValue)) {
                $document[$propName] = $propValue;
            } elseif ($propValue instanceof static) {
                $document[$propName] = $propValue->fetchDocument();
            }
        }
        return $document;
    }

    /**
     * @param BSONDocument $document
     * @return MongoRepository
     */
    protected function buildFromDocument($document): MongoRepository
    {
        $this->id = ((array)$document["_id"])['oid'] ?? "";
        $this->buildFromArray((array)$document);
        $this->exists = true;
        return $this;
    }

    /**
     * @return array
     */
    private function replaceUniqueIndexes()
    {
        $rIdxes = [];
        $indexes = array_filter(static::$indexes, function (array $idx) {
            return $idx["unique"] === true && ($idx["key"] ?? null);
        });
        foreach ($indexes as $index) {
            foreach (array_keys($index["key"]) as $iKey) {
                $rIdxes[$iKey] = $this->$iKey;
            }
        }
        return $rIdxes;
    }
}