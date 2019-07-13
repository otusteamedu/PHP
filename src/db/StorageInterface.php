<?php

namespace crazydope\youtube\db;

use crazydope\youtube\ArrayDocumentInterface;
use MongoDB\DeleteResult;
use MongoDB\InsertManyResult;
use MongoDB\InsertOneResult;

interface StorageInterface
{
    public function insertOne(ArrayDocumentInterface $data): InsertOneResult;

    public function insertMany(array $data): InsertManyResult;

    public function find(array $filter, array $options = []): array;

    public function delete(string $id): DeleteResult;

    public function aggregate(array $pipeline, array $options): \Traversable;
}