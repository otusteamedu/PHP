<?php

namespace crazydope\theater\database;

interface IdentityMapInterface
{
    public function set(int $id, $object);

    public function getId($object): int;

    public function hasId(int $id): bool;

    public function hasObject($object): bool;

    public function getObject(int $id);

    public function deleteObject(int $id): void;
}