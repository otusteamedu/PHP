<?php

use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class FilmSeeder extends AbstractSeed
{
    public function run(): void
    {
        $faker = Factory::create();
        $years = [2017, 2018, 2019];

        $this->clearTable();

        $filmTable = $this->table('films');

        foreach (range(1, 50) as $i) {
            $data = [
                'title' => $faker->unique()->sentence,
                'year' => $years[array_rand($years)],
            ];
            $filmTable->insert($data)->save();
        }
    }

    private function clearTable(): void
    {
        $this->adapter->execute('delete from films');
    }
}
