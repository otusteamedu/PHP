<?php

namespace App\Commands;

class SeedCommand implements CommandInterface
{
    public function execute (array $params): string
    {
        return json_encode(
            [
                'result' => 'success',
                'msg'    => 'seed test',
            ]
        );
    }
}