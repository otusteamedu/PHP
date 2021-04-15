<?php

namespace App\Commands;

use App\DbSeeder\DbSeeder;
use App\Storage\Storage;

class SeedCommand implements CommandInterface
{
    public function execute (array $params): string
    {
        if (DbSeeder::seed()) {
            return json_encode(
                [
                    'result' => 'success',
                    'msg'    => 'seeded',
                ]
            );
        }

        return json_encode(
            [
                'result' => 'error',
                'msg'    => 'error seeding db',
            ]
        );
    }
}