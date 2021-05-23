<?php
declare(strict_types=1);

namespace DesignPatterns\Factories;

use JetBrains\PhpStorm\Pure;
use DesignPatterns\Meals\HotDog;
use DesignPatterns\Meals\MealInterface;

class HotDogFactoryInterface implements FactoryInterface
{
    /**
     * @return MealInterface
     */
    #[Pure]
    public function createMeal(): MealInterface
    {
        return new HotDog();
    }
}
