<?php
declare(strict_types=1);

namespace DesignPatterns\Factories;

use JetBrains\PhpStorm\Pure;
use DesignPatterns\Meals\Burger;
use DesignPatterns\Meals\MealInterface;

class BurgerFactoryInterface implements FactoryInterface
{

    /**
     * @return MealInterface
     */
    #[Pure]
    public function createMeal(): MealInterface
    {
        return new Burger();
    }
}
