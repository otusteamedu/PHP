<?php
declare(strict_types=1);

namespace DesignPatterns\Meals;

class Sandwich implements MealInterface
{
    /**
     * @return string
     */
    public function cook(): string
    {
        return 'Sandwich';
    }
}
