<?php
declare(strict_types=1);

namespace DesignPatterns\Meals;

interface MealInterface
{
    /**
     * @return string
     */
    public function cook(): string;
}
