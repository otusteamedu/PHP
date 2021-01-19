<?php

namespace VideoPlatform\models;

use VideoPlatform\interfaces\DBInterface;

abstract class ActiveRecord
{
    abstract public static function findById(DBInterface $db, $id);
    abstract public function save(DBInterface $db);
    abstract public static function getAll(DBInterface $db, $limit, $offset);
}