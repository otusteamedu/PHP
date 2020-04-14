<?php

namespace App;

use MongoDB\Client;
use MongoDB\Database;
use Traversable;

final class Mongo implements Db
{
    private ?Database $database = null;

    private function init(): void
    {
        if (null === $this->database) {
            $this->database = (new Client(getenv('APP_DSN_MONGO')))->youtube;
        }
    }

    public function save(object $data, string $collection): void
    {
        $this->init();
        $this->database->$collection->replaceOne(['_id' => $data->_id], $data, ['upsert' => true]);
    }

    public function addIndex(string $collection, string $key, array $options = []): void
    {
        $this->init();
        $this->database->$collection->createIndex([$key => 1], $options);
    }

    public function aggregate(string $collection, array $pipeline): Traversable
    {
        $this->init();
        return $this->database->$collection->aggregate($pipeline);
    }
}
