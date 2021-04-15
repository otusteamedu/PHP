<?php

namespace App\Commands;

use App\DbSeeder\DbSeeder;
use App\Storage\Storage;

class SeedCommand implements CommandInterface
{
    public function execute (array $params): string
    {
        DbSeeder::seed();

        return json_encode(
            [
                'result' => 'success',
                'msg'    => 'seed test',
            ]
        );
    }
}