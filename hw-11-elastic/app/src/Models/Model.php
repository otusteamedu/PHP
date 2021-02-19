<?php

namespace Models;

use Storage\Storage;

class Model
{
    public function store (DTO $dto)
    {
        return Storage::getInstance()->getStorage()->store($dto, static::TABLE_NAME);
    }
}
