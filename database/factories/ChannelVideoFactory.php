<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\ChannelVideo;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChannelVideoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ChannelVideo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'likes' => $this->faker->numberBetween(100, 100000),
            'dislikes' => $this->faker->numberBetween(100, 100000),
            'views' => $this->faker->numberBetween(1000, 1000000),
        ];
    }
}
