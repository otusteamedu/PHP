<?php

use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class GenreSeeder extends AbstractSeed
{
    public function run(): void
    {
        $faker = Factory::create();

        $this->clearTable();

        $genresTable = $this->table('genres');

        foreach (range(1, 10) as $i) {
            $data = [
                'title' => $faker->unique()->word,
            ];

            $genresTable->insert($data)->save();
        }
    }

    private function clearTable(): void
    {
        $this->adapter->execute('delete from films');
    }
}
