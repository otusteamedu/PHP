<?php
declare(strict_types=1);

namespace DesignPatterns\Factories;

use JetBrains\PhpStorm\Pure;
use DesignPatterns\Meals\Sandwich;
use DesignPatterns\Meals\MealInterface;

class SandwichFactory implements FactoryInterface
{
    /**
     * @return MealInterface
     */
    #[Pure]
    public function createMeal(): MealInterface
    {
        return new Sandwich();
    }
}
