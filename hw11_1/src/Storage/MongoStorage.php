<?php

declare(strict_types=1);

namespace App\Storage;

use App\Contracts\Storage;
use App\Entities\YouTubeChannel;
use MongoDB\Client;
use MongoDB\Collection;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Exception\Exception;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;

class MongoStorage implements Storage
{
    /**
     * @var Client
     */
    private $manager;
    /**
     * @var Collection
     */
    private $dbCollection;
    /**
     * @var string
     */
    private $namespace;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $port = $params['port'] ?? 27017;
        $connection ="mongodb://{$params['user']}:{$params['password']}@{$params['host']}:{$port}/{$params['db']}";

        $this->manager = new Manager($connection, [
            'typeMap' => ['root' => 'array', 'document' => 'array', 'array' => 'array'],
        ]);

        $this->namespace = "{$params['db']}.{$params['collection']}";
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        $query = new Query([]);

        try {
            $rows = $this->manager->executeQuery($this->namespace, $query)->toArray();
        } catch (Exception $e) {
            throw new \RuntimeException('Error while reading all rows.', 0, $e);
        }

        $channels = [];

        foreach ($rows as $row) {
            $channels[] = YouTubeChannel::createFromObject($row);
        }

        return $channels;
    }

    /**
     * @inheritDoc
     */
    public function getById($id): ?YouTubeChannel
    {
        $query = new Query(['id' => $id]);

        try {
            $rows = $this->manager->executeQuery($this->namespace, $query)->toArray();
        } catch (Exception $e) {
            throw new \RuntimeException('Error while getting by ID.', 0, $e);
        }

        if (empty($rows)) {
            return null;
        } else {
            return YouTubeChannel::createFromObject($rows[0]);
        }
    }

    /**
     * @inheritDoc
     */
    public function insert(array $data): bool
    {
        $bulk = new BulkWrite;

        $bulk->insert($data);

        $result = $this->manager->executeBulkWrite($this->namespace, $bulk);

        if ($result && $result->getInsertedCount() > 0) {
            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function update(array $data)
    {
        //
    }

    /**
     * @inheritDoc
     */
    public function delete(array $data)
    {
        //
    }
}
