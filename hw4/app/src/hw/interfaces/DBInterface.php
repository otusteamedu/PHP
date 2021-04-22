<?php


namespace VideoPlatform\interfaces;


interface DBInterface
{
    const ELASTIC_SEARCH = 'ElasticSearch';

    public function save(array $data);

    public function findById($tableName, $id): array;

    public function query($tableName, $queryParams);

    public function getAll($tableName, $limit, $offset);
}
