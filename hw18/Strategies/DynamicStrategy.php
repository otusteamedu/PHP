<?php
declare(strict_types=1);

namespace DesignPatterns\Strategies;

use DesignPatterns\Meals\MealInterface;
use DesignPatterns\Decorators\AbstractDecorator;

class DynamicStrategy implements StrategyInterface
{
    /**
     * @var string[]
     */
    private array $ingredients;

    /**
     * @var string
     */
    private string $basis;

    /**
     * DynamicStrategy constructor.
     *
     * @param $ingredients
     * @param $basis
     */
    public function __construct($ingredients, $basis)
    {
        $this->ingredients = $ingredients;
        $this->basis = $basis;
    }

    /**
     * @return MealInterface
     */
    public function prepareOrder(): MealInterface
    {
        $decorators = array_map(function ($value) {
            $capitalized = ucfirst($value);
            return "{$capitalized}Decorator";
        }, $this->ingredients);

        $decoratorChain = array_merge($decorators, [ucfirst($this->basis)]);
        /*
         * Decorator chain now looks like:
         * [
         *      'SauceDecorator',
         *      'SaladDecorator',
         *      'TomatoDecorator',
         *      'Burger'
         * ]
         */
        return AbstractDecorator::makeChain($decoratorChain);
    }
}
