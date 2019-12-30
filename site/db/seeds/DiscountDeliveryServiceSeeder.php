<?php


use Phinx\Seed\AbstractSeed;

class DiscountDeliveryServiceSeeder extends AbstractSeed
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
                'discount_delivery_service_rub' => $faker->numberBetween($min = 10, $max = 60),
                'discount_delivery_service_coefficient'=>$faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 1)
            ];
        }

        $this->table('discount_delivery_service')->insert($data)->save();
    }
}
