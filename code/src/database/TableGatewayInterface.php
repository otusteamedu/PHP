<?php

namespace crazydope\theater\database;

interface TableGatewayInterface
{
    public function select($where = []);

    public function insert(array $set): int;

    public function update(array $set, $where = []): int;

    public function delete($where = []): int;

    public function lastInsertId($name = null): int;

    public function getTable();
}