<?php


namespace VideoPlatform\interfaces;


interface DBInterface
{
    const ELASTIC_SEARCH = 'ElasticSearch';
    const MONGO_DB = 'MongoDB';

    public function save(array $data): bool;

    public function  findById($tableName, $id): array;

    public function query($tableName, $queryParams);

//    public function scroll();
}