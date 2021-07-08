<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $conditions = $this->faker->randomElements([
            'param1',
            'param2',
            'param3',
            'param4',
            'param5',
            'param6',
            'param7',
            'param8',
            'param9',
            'param10',
        ], rand(1,5));

        $conditionsValues = [
            'param1' => rand(1,11),
            'param2' => rand(1,11),
            'param3' => rand(1,11),
            'param4' => rand(1,11),
            'param5' => rand(1,11),
            'param6' => rand(1,11),
            'param7' => rand(1,11),
            'param8' => rand(1,11),
            'param9' => rand(1,11),
            'param10' => rand(1,11),
        ];

        $result = array_reduce($conditions, function($carry, $item) use ($conditionsValues) {
            return array_merge($carry, [$item => $conditionsValues[$item]]);
        }, []);

        return [
            'priority' => rand(1, 10000),
            'conditions' => $result,
            'name' => 'Event'.rand(1000,1000000),
        ];
    }
}
