<?php


namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition()
    {
        return [
            'id' => $this->faker->uuid
        ];
    }
}