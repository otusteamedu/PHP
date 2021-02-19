<?php

namespace Models;

use Storage\Storage;

class Mapper
{
    public static function getAll()
    {
        return Storage::getInstance()->getStorage()->getAll(static::TABLE_NAME);
    }
}
