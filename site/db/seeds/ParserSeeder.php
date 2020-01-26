<?php


use Phinx\Seed\AbstractSeed;

class ParserSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'parser_name' => $faker->name,
                'product_id'=>$faker->numberBetween($min = 1, $max = 10)
            ];
        }

        $this->table('parser')->insert($data)->save();

    }
}
