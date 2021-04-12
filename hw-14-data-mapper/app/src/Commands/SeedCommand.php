<?php

namespace App\Commands;

use App\Storage\Storage;

class SeedCommand implements CommandInterface
{
    public function execute (array $params): string
    {
        $pdo = Storage::getInstance();

        return json_encode(
            [
                'result' => 'success',
                'msg'    => 'seed test',
            ]
        );
    }
}