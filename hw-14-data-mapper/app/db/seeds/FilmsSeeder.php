<?php

use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class FilmsSeeder extends AbstractSeed
{
    private const FAKE_RECORDS_COUNT = 50;

    public function run ()
    {
        $data  = [];
        $faker = Factory::create();

        for ($i = 1; $i <= self::FAKE_RECORDS_COUNT; $i++) {
            $data[] = [
                'title'           => $faker->name,
                'show_start_date' => $faker->date('Y-m-d h:i:00'),
                'length'          => $faker->numberBetween(80, 240),
            ];
        }

        $films = $this->table('films');
        $films->insert($data)
              ->saveData();
    }
}
