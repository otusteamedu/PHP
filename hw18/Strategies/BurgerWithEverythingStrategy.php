<?php
declare(strict_types=1);

namespace DesignPatterns\Strategies;

use JetBrains\PhpStorm\Pure;
use DesignPatterns\Meals\Burger;
use DesignPatterns\Meals\MealInterface;
use DesignPatterns\Decorators\SaladDecorator;
use DesignPatterns\Decorators\SauceDecorator;
use DesignPatterns\Decorators\PepperDecorator;
use DesignPatterns\Decorators\TomatoDecorator;

class BurgerWithEverythingStrategy implements StrategyInterface
{
    /**
     * @return MealInterface
     */
    #[Pure]
    public function prepareOrder(): MealInterface
    {
        return new SauceDecorator(
            new PepperDecorator(
                new SaladDecorator(
                    new TomatoDecorator(
                        new Burger()
                    )
                )
            )
        );
    }
}