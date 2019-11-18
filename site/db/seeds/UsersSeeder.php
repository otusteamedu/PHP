<?php

use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
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
                'login' => $faker->firstName,
                'name' => $faker->firstName,
                'surname' => $faker->lastName,
                'age'=>$faker->numberBetween($min = 10, $max = 60),
                'tel' => $faker->phoneNumber,
                'address' => $faker->address,
                'created' => $faker->date($format = 'Y-m-d H:i:s', $max = 'now'),
                'email'=>$faker->email,
                'admin'=>$faker->randomElement($array = array ('yes','no')),
                'password' => sha1($faker->password),
            ];
        }

        $this->table('users')->insert($data)->save();
    }
}
