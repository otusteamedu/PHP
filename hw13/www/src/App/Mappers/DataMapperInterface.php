<?php

namespace App\Mappers;

interface DataMapperInterface
{
    public function findById($id): object;
    public function insert(object $userEntity): int;
    public function update(object $userEntity): bool;
    public function delete(object $userEntity): bool;
}