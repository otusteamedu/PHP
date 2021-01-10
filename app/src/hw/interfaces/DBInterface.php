<?php


namespace VideoPlatform\interfaces;


interface DBInterface
{
    const ELASTIC_SEARCH = 'ElasticSearch';
    const MONGO_DB = 'MongoDB';

    public function connect(): bool;

    public function save(array $data): bool;
}