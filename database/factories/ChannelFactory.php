<?php

namespace Database\Factories;

use App\Models\Channel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChannelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Channel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tags = collect(['health', 'dev', 'entertaining', 'live', 'games', 'work', 'business', 'nature', 'space', 'study'])
            ->random(3)
            ->values()
            ->all();
        return [
            'name'        => $this->faker->userName,
            'tags'        => $tags,
            'description' => $this->faker->text(),
        ];
    }
}
