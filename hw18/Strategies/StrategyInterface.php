<?php
declare(strict_types=1);

namespace DesignPatterns\Strategies;

use DesignPatterns\Meals\MealInterface;

interface StrategyInterface
{
    /**
     * @return MealInterface
     */
    public function prepareOrder(): MealInterface;
}
