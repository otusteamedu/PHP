<?php

namespace App\Commands;

use App\Storage\Storage;

class DeleteCommand implements CommandInterface
{
    public function execute (array $params): string
    {
        $affected = Storage::getInstance()->getStorage()->deleteAll();

        return json_encode(
            [
                'result' => 'success',
                'msg'    => $affected . ' records deleted',
            ]
        );
    }
}