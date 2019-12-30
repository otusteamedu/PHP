<?php


use Phinx\Seed\AbstractSeed;

class DeliveryServiceSeeder extends AbstractSeed
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
                'name_delivery_service' => $faker->name,
                'price'=>$faker->numberBetween($min=1000,$max=1000000000),
                'discount_delivery_service_id'=>$faker->numberBetween($min=1,$max=100)
            ];
        }

        $this->table('delivery_service')->insert($data)->save();
    }
}
