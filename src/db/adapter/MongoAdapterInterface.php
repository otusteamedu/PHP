<?php

namespace crazydope\youtube\db\adapter;

use MongoDB\Database;
use MongoDB\DeleteResult;
use MongoDB\InsertManyResult;
use MongoDB\InsertOneResult;

interface MongoAdapterInterface
{
    public function getDB(): Database;

    public function insertOnce(string $collection, array $document): InsertOneResult;

    public function insertMany(string $collection, array $documents): InsertManyResult;

    public function find(string $collection, array $filter, array $options = []): array;

    public function delete(string $collection, string $id): DeleteResult;

    public function aggregate(string $collection, array $pipeline, array $options): \Traversable;
}