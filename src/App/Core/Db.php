<?php
namespace Ozycast\App\Core;

interface Db
{
    public function connect(): Db;

    /**
     * @param array $collection
     * @param array $data
     * @return bool
     */
    public function insert($collection, $data): bool;

    /**
     * @param array $collection
     * @param array $filter
     * @param array $data
     * @return bool
     */
    public function update($collection, $filter, $data): bool;

    /**
     * @param array $collection
     * @param array $params
     * @return object|null
     */
    public function findAll($collection, $params);

    /**
     * @param $collection
     * @param $params
     * @return object|null
     */
    public function findOne($collection, $params);
}