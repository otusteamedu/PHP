<?php
declare(strict_types=1);

namespace DesignPatterns\Factories;

use DesignPatterns\Meals\MealInterface;

interface FactoryInterface
{
    /**
     * @return MealInterface
     */
    public function createMeal(): MealInterface;
}
