<?php
declare(strict_types=1);

namespace DesignPatterns\Meals;

class Burger implements MealInterface
{
    /**
     * @return string
     */
    public function cook(): string
    {
        return 'Burger';
    }
}
