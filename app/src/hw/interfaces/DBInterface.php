<?php

namespace VideoPlatform\interfaces;

interface DBInterface
{
    const ELASTIC_SEARCH = 'ElasticSearch';
    const MONGO_DB = 'MongoDB';

    public function save(array $data);

    public function  findById($tableName, $id): array;

    public function query($tableName, $queryParams);

    public function getAll($tableName, $limit, $offset);
}
