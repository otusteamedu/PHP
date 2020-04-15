<?php

namespace App;

use MongoDB\Client;
use MongoDB\Database;

final class Mongo implements Db
{
    use MongoAggregate;

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
}
