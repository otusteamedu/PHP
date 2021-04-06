<?php

namespace App\Commands;

use App\Storage\Storage;

class ListCommand implements CommandInterface
{
    public function execute (array $params): string
    {
        return json_encode(Storage::getInstance()->getStorage()->getList());
    }
}